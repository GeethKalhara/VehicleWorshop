<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Unit\Http\Response;

use Generator;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpStatus;
use Vwork\Web\Http\Response\Response;
use Vwork\Web\WebError;

/**
 * Response::stream(status, headers)->...
 *
 * html/text/json are SSE over an iterable: key = event name, value = payload.
 * file streams a file from disk in chunks.
 */
final class StreamResponsesTest extends TestCase
{
    private const array SSE = [
        'Content-Type' => ['text/event-stream; charset=utf-8'],
        'Cache-Control' => ['no-cache'],
        'X-Accel-Buffering' => ['no'],
    ];

    private static function body(Response $response): string
    {
        ob_start();
        try {
            $response->send(true);
            return (string) ob_get_contents();
        } finally {
            ob_end_clean(); // close the buffer even when send() throws, or PHPUnit flags the test as risky
        }
    }

    /**
     * @template K of array-key
     * @template V
     * @param array<K, V> $events
     * @return Generator<K, V>
     */
    private static function gen(array $events): Generator
    {
        yield from $events;
    }

    /** @return non-empty-string */
    private static function tempFile(string $contents): string
    {
        /** @var non-empty-string */
        $path = (string) tempnam(sys_get_temp_dir(), 'vwork_');
        file_put_contents($path, $contents);
        return $path;
    }

    // ---- SSE: headers and laziness ----

    #[Test]
    #[TestWith(['html'])]
    #[TestWith(['text'])]
    #[TestWith(['json'])]
    public function sse_sets_stream_headers(string $method): void
    {
        /** @var Response $response */
        $response = Response::stream()->$method([]);

        $this->assertSame(HttpStatus::Ok, $response->status);
        $this->assertSame(self::SSE, $response->headers->list);
    }

    #[Test]
    public function sse_pulls_events_only_on_send(): void
    {
        $pulled = 0;
        $events = (static function () use (&$pulled): Generator {
            $pulled++;
            yield 'a' => 'x';
        })();

        $response = Response::stream()->html($events);
        $this->assertSame(0, $pulled);

        self::body($response);
        $this->assertSame(1, $pulled);
    }

    #[Test]
    public function sse_accepts_a_plain_array_too(): void
    {
        $this->assertSame("event: a\ndata: x\n\n", self::body(Response::stream()->text(['a' => 'x'])));
    }

    // ---- SSE: framing ----

    /**
     * @param array<array-key, string> $events
     */
    #[Test]
    #[TestWith([[], ''])]                                                     // no events, no output
    #[TestWith([['board' => '<p>x</p>'], "event: board\ndata: <p>x</p>\n\n"])]
    #[TestWith([['a' => '1', 'b' => '2'], "event: a\ndata: 1\n\nevent: b\ndata: 2\n\n"])]
    #[TestWith([['dummy:event' => 'x'], "event: dummy:event\ndata: x\n\n"])]  // colons are fine in names
    #[TestWith([['x'], "data: x\n\n"])]                                       // int key: unnamed, arrives as 'message'
    #[TestWith([['a' => ''], "event: a\ndata: \n\n"])]                        // empty payload still one data line
    #[TestWith([['a' => "<ul>\n<li>1</li>\n</ul>"], "event: a\ndata: <ul>\ndata: <li>1</li>\ndata: </ul>\n\n"])]
    #[TestWith([['a' => "x\n"], "event: a\ndata: x\ndata: \n\n"])]            // trailing newline survives the round trip
    public function html_frames_each_event(array $events, string $expected): void
    {
        $this->assertSame($expected, self::body(Response::stream()->html(self::gen($events))));
    }

    /**
     * EventSource also splits lines on a bare CR and on CRLF. A payload
     * split only on LF lets a CR end the data line early, and whatever
     * follows it is parsed as a new field (e.g. "event:", "id:").
     *
     * @param array<array-key, string> $events
     */
    #[Test]
    #[TestWith([['a' => "x\r\ny"], "event: a\ndata: x\ndata: y\n\n"])]
    #[TestWith([['a' => "x\rid: 9"], "event: a\ndata: x\ndata: id: 9\n\n"])]
    public function html_splits_payload_on_every_sse_line_ending(array $events, string $expected): void
    {
        $this->assertSame($expected, self::body(Response::stream()->html(self::gen($events))));
    }

    /**
     * @param array<array-key, array<string, mixed>> $events
     */
    #[Test]
    #[TestWith([['job.updated' => ['id' => 1]], "event: job.updated\ndata: {\"id\":1}\n\n"])]
    #[TestWith([['note' => ['text' => "l1\nl2"]], "event: note\ndata: {\"text\":\"l1\\nl2\"}\n\n"])]  // newline escaped, stays one line
    #[TestWith([['note' => []], "event: note\ndata: []\n\n"])]
    #[TestWith([['link' => ['url' => '/jobs/1', 'name' => 'රසීද']], "event: link\ndata: {\"url\":\"/jobs/1\",\"name\":\"රසීද\"}\n\n"])]
    public function json_frames_each_event_as_json(array $events, string $expected): void
    {
        $this->assertSame($expected, self::body(Response::stream()->json(self::gen($events))));
    }

    #[Test]
    public function json_throws_on_send_for_data_it_cannot_encode(): void
    {
        $response = Response::stream()->json(self::gen(['bad' => ['text' => "\xB1\x31"]]));

        $this->expectException(JsonException::class);
        self::body($response);
    }

    #[Test]
    public function html_throws_on_send_for_a_non_string_event(): void
    {
        // @phpstan-ignore argument.type (deliberately wrong type: checks the runtime guard)
        $response = Response::stream()->html(self::gen(['a' => ['not', 'a', 'string']]));

        $this->expectException(WebError::class);
        self::body($response);
    }

    // ---- SSE: status and headers ----

    #[Test]
    public function sse_accepts_an_explicit_200(): void
    {
        $this->assertSame(HttpStatus::Ok, Response::stream(HttpStatus::Ok)->html([])->status);
    }

    #[Test]
    #[TestWith(['html', HttpStatus::Created])]
    #[TestWith(['text', HttpStatus::NoContent])]
    #[TestWith(['json', HttpStatus::NotFound])]
    public function sse_rejects_anything_but_200(string $method, HttpStatus $status): void
    {
        $this->expectException(WebError::class);
        $this->expectExceptionMessage("Status {$status->value} is not valid for stream()->{$method}()");

        Response::stream($status)->$method([]);
    }

    #[Test]
    public function sse_keeps_its_content_type_over_the_callers(): void
    {
        $response = Response::stream(headers: ['Content-Type' => ['text/html']])->html([]);

        $this->assertSame(['text/event-stream; charset=utf-8'], $response->headers[ResponseHeaders::ContentType]);
    }

    #[Test]
    public function sse_appends_to_caller_list_headers(): void
    {
        $response = Response::stream(headers: ['Cache-Control' => ['private']])->html([]);

        $this->assertSame(['private', 'no-cache'], $response->headers[ResponseHeaders::CacheControl]);
    }

    // ---- file ----

    #[Test]
    #[TestWith(['0123456789', 'invoice.pdf', 'attachment; filename="invoice.pdf"; filename*=UTF-8\'\'invoice.pdf'])]
    #[TestWith(["binary\x00payload", 'x.bin', 'attachment; filename="x.bin"; filename*=UTF-8\'\'x.bin'])]
    #[TestWith(['', 'invoice "final".pdf', 'attachment; filename="invoice \"final\".pdf"; filename*=UTF-8\'\'invoice%20%22final%22.pdf'])]
    #[TestWith(['x', 'රසීද.pdf', 'attachment; filename="____________.pdf"; filename*=UTF-8\'\'%E0%B6%BB%E0%B7%83%E0%B7%93%E0%B6%AF.pdf'])]
    public function file_sets_download_headers_and_streams_contents(string $contents, string $name, string $disposition): void
    {
        $path = self::tempFile($contents);

        try {
            $response = Response::stream()->file($path, $name);

            $this->assertSame(HttpStatus::Ok, $response->status);
            $this->assertSame([
                'Content-Type' => ['application/octet-stream'],
                'Content-Disposition' => [$disposition],
                'Content-Length' => [(string) strlen($contents)],
            ], $response->headers->list);
            $this->assertSame($contents, self::body($response));
        } finally {
            unlink($path);
        }
    }

    #[Test]
    public function file_streams_contents_larger_than_one_chunk(): void
    {
        $contents = random_bytes(65536 * 2 + 17); // three reads, last one partial
        $path = self::tempFile($contents);

        try {
            $this->assertSame($contents, self::body(Response::stream()->file($path, 'big.bin')));
        } finally {
            unlink($path);
        }
    }

    #[Test]
    public function file_reads_the_file_on_send_not_on_build(): void
    {
        $path = self::tempFile('before');

        try {
            $response = Response::stream()->file($path, 'x.txt');
            file_put_contents($path, 'after!'); // same length, so Content-Length still matches

            $this->assertSame('after!', self::body($response));
        } finally {
            unlink($path);
        }
    }

    #[Test]
    #[TestWith(['/vwork_definitely_missing'])] // doesn't exist
    #[TestWith([''])]                          // the temp dir itself: exists, not a file
    public function file_throws_unless_path_is_a_regular_file(string $suffix): void
    {
        $this->expectException(WebError::class);
        Response::stream()->file(sys_get_temp_dir() . $suffix, 'x');
    }

    #[Test]
    #[TestWith([HttpStatus::Ok])]
    #[TestWith([HttpStatus::PartialContent])]
    public function file_accepts_200_and_206(HttpStatus $status): void
    {
        $path = self::tempFile('x');

        try {
            $this->assertSame($status, Response::stream($status)->file($path, 'x')->status);
        } finally {
            unlink($path);
        }
    }

    #[Test]
    #[TestWith([HttpStatus::Created])]
    #[TestWith([HttpStatus::NoContent])]
    #[TestWith([HttpStatus::NotFound])]
    public function file_rejects_other_statuses(HttpStatus $status): void
    {
        $path = self::tempFile('x');

        try {
            $this->expectException(WebError::class);
            $this->expectExceptionMessage("Status {$status->value} is not valid for stream()->file()");
            Response::stream($status)->file($path, 'x');
        } finally {
            unlink($path);
        }
    }
}
