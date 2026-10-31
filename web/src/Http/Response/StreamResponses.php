<?php

declare(strict_types=1);

namespace Vwork\Web\Http\Response;

use Closure;
use Vwork\Web\WebError;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpStatus;

/**
 * Responses whose body is produced over time.
 *
 * Obtained via Response::stream(status, headers). html/text/json/cbor
 * are SSE: pass an iterable (usually a generator) where each key is the
 * event name and each value the payload:
 *
 *     Response::stream()->json((function (): Generator {
 *         yield 'progress' => ['pct' => 50];
 *         yield 'done' => ['ok' => true];
 *     })());
 *
 * An integer key (plain `yield $value`) sends an unnamed event, which
 * EventSource delivers as 'message'.
 */
final readonly class StreamResponses
{
    private const int FILE_CHUNK = 65536;

    /**
     * @param array<value-of<ResponseHeaders>, list<string>> $headers
     */
    public function __construct(
        private ?HttpStatus $status,
        private array $headers,
    ) {
    }

    /** @param iterable<string|int, string> $events */
    public function html(iterable $events): Response
    {
        return $this->sse(Format::Html, $events, __FUNCTION__);
    }

    /** @param iterable<string|int, string> $events */
    public function text(iterable $events): Response
    {
        return $this->sse(Format::Text, $events, __FUNCTION__);
    }

    /** @param iterable<string|int, array<string, mixed>> $events */
    public function json(iterable $events): Response
    {
        return $this->sse(Format::Json, $events, __FUNCTION__);
    }

    // /**
    //  * SSE is UTF-8 text, so each CBOR payload is base64-encoded.
    //  *
    //  * @param iterable<string|int, array<string, mixed>> $events
    //  */
    // public function cbor(iterable $events): Response
    // {
    //     return $this->sse(Format::Cbor, $events, __FUNCTION__, base64: true);
    // }

    /**
     * Sends a file from disk in chunks, as a download.
     *
     * @throws WebError if the file isn't there or its size can't be read
     */
    public function file(string $path, string $name): Response
    {
        if (!is_file($path)) {
            throw new WebError("Cannot send file, not found: {$path}");
        }

        $size = filesize($path);
        if ($size === false) {
            throw new WebError("Cannot determine size of file: {$path}");
        }

        $status = $this->resolve(
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s === HttpStatus::Ok || $s === HttpStatus::PartialContent,
        );

        $ascii = addcslashes(preg_replace('/[^\x20-\x7E]/', '_', $name) ?? 'download', '"\\');

        return $this->finish(
            $status,
            [
                ResponseHeaders::ContentType->value => ['application/octet-stream'],
                ResponseHeaders::ContentDisposition->value => [
                    "attachment; filename=\"{$ascii}\"; filename*=UTF-8''" . rawurlencode($name),
                ],
                ResponseHeaders::ContentLength->value => [(string) $size],
            ],
            static function () use ($path): void {
                $fh = fopen($path, 'rb');
                if ($fh === false) {
                    throw new WebError("Cannot open file: {$path}");
                }

                try {
                    while (!feof($fh) && !connection_aborted()) {
                        $chunk = fread($fh, self::FILE_CHUNK);
                        if ($chunk === false) {
                            break;
                        }
                        echo $chunk;
                        flush();
                    }
                } finally {
                    fclose($fh);
                }
            },
        );
    }

    // ── helpers ────────────────────────────────────────────────

    /**
     * EventSource treats anything but 200 as a failed connection,
     * so SSE only accepts 200.
     *
     * @param iterable<string|int, mixed> $events
     */
    private function sse(Format $format, iterable $events, string $method, bool $base64 = false): Response
    {
        $status = $this->resolve($method, static fn (HttpStatus $s): bool => $s === HttpStatus::Ok);

        return $this->finish(
            $status,
            [
                ResponseHeaders::ContentType->value => ['text/event-stream; charset=utf-8'],
                ResponseHeaders::CacheControl->value => ['no-cache'],
                ResponseHeaders::XAccelBuffering->value => ['no'],
            ],
            static function () use ($format, $events, $base64): void {
                foreach ($events as $event => $value) {
                    if (connection_aborted()) {
                        return;
                    }

                    $payload = $format->encode($value);
                    if ($base64) {
                        $payload = base64_encode($payload);
                    }

                    $frame = is_string($event) ? "event: {$event}\n" : '';

                    $payload = str_replace(["\r\n", "\r"], "\n", $payload);
                    foreach (explode("\n", $payload) as $line) {
                        $frame .= "data: {$line}\n";
                    }

                    echo $frame, "\n";
                    flush();
                }
            },
        );
    }

    /**
     * Caller's headers first, the method's own after (see SingleResponses::finish).
     *
     * @param array<value-of<ResponseHeaders>, list<string>> $own
     * @param Closure(): void $sender
     */
    private function finish(HttpStatus $status, array $own, Closure $sender): Response
    {
        $response = Response::build($status, $this->headers, $sender);

        foreach ($own as $name => $values) {
            foreach ($values as $value) {
                $response->addHeader(ResponseHeaders::from($name), $value);
            }
        }

        return $response;
    }

    /**
     * Streams all default to 200.
     *
     * @param Closure(HttpStatus): bool $allowed
     * @throws WebError on a status this method can't send
     */
    private function resolve(string $method, Closure $allowed): HttpStatus
    {
        if ($this->status === null) {
            return HttpStatus::Ok;
        }

        if (!$allowed($this->status)) {
            throw new WebError("Status {$this->status->value} is not valid for stream()->{$method}()");
        }

        return $this->status;
    }
}
