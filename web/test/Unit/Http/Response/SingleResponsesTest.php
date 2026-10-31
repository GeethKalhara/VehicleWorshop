<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Unit\Http\Response;

use JsonException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpMethods;
use Vwork\Web\Http\HttpStatus;
use Vwork\Web\Http\Response\Response;
use Vwork\Web\WebError;

/**
 * Response::single(status, headers)->...
 *
 * Every method has a default status, accepts some overrides and throws
 * on the rest. Caller headers go in first, the method's own after.
 */
final class SingleResponsesTest extends TestCase
{
    private const array HTML = ['Content-Type' => ['text/html; charset=utf-8']];
    private const array TEXT = ['Content-Type' => ['text/plain; charset=utf-8']];
    private const array JSON = ['Content-Type' => ['application/json; charset=utf-8']];

    private static function body(Response $response): string
    {
        ob_start();
        $response->send(true);
        return (string) ob_get_clean();
    }

    // ---- defaults ----

    /**
     * @param list<mixed> $args
     * @param array<string, list<string>> $headers
     */
    #[Test]
    #[TestWith(['html', ['<p>x</p>'], HttpStatus::Ok, self::HTML, '<p>x</p>'])]
    #[TestWith(['html', [''], HttpStatus::Ok, self::HTML, ''])]
    #[TestWith(['text', ['0'], HttpStatus::Ok, self::TEXT, '0'])]
    #[TestWith(['json', [['a' => 1]], HttpStatus::Ok, self::JSON, '{"a":1}'])]
    #[TestWith(['json', [[]], HttpStatus::Ok, self::JSON, '[]'])]
    #[TestWith(['error', ['nope'], HttpStatus::InternalServerError, self::TEXT, 'nope'])]
    #[TestWith(['error', [], HttpStatus::InternalServerError, self::TEXT, ''])]
    #[TestWith(['redirect', ['/jobs/42'], HttpStatus::Found, ['Location' => ['/jobs/42']], ''])]
    #[TestWith(['clientRedirect', ['/login'], HttpStatus::NoContent, ['X-Attr-Redirect' => ['/login']], ''])]
    #[TestWith(['methodNotAllowed', [[HttpMethods::GET, HttpMethods::POST]], HttpStatus::MethodNotAllowed, ['Allow' => ['GET', 'POST']], ''])]
    #[TestWith(['noContent', [], HttpStatus::NoContent, [], ''])]
    public function each_method_builds_its_default_response(string $method, array $args, HttpStatus $status, array $headers, string $body): void
    {
        /** @var Response $response */
        $response = Response::single()->$method(...$args);

        $this->assertSame($status, $response->status);
        $this->assertSame($headers, $response->headers->list);
        $this->assertSame($body, self::body($response));
    }

    // ---- status overrides ----

    /**
     * @param list<mixed> $args
     */
    #[Test]
    #[TestWith(['html', ['x'], HttpStatus::NotFound])]
    #[TestWith(['html', ['x'], HttpStatus::UnprocessableEntity])]
    #[TestWith(['text', ['x'], HttpStatus::Created])]
    #[TestWith(['json', [[]], HttpStatus::Created])]
    #[TestWith(['json', [[]], HttpStatus::Conflict])]
    #[TestWith(['error', ['x'], HttpStatus::BadRequest])]
    #[TestWith(['error', ['x'], HttpStatus::ServiceUnavailable])]
    #[TestWith(['redirect', ['/x'], HttpStatus::SeeOther])]
    #[TestWith(['clientRedirect', ['/x'], HttpStatus::NoContent])]
    #[TestWith(['methodNotAllowed', [[]], HttpStatus::MethodNotAllowed])]
    #[TestWith(['noContent', [], HttpStatus::NoContent])]
    public function a_valid_status_override_is_used(string $method, array $args, HttpStatus $status): void
    {
        /** @var Response $response */
        $response = Response::single($status)->$method(...$args);

        $this->assertSame($status, $response->status);
    }

    /**
     * @param list<mixed> $args
     */
    #[Test]
    #[TestWith(['html', ['x'], HttpStatus::NoContent])]      // 204 must not have a body
    #[TestWith(['html', ['x'], HttpStatus::NotModified])]    // 304 neither
    #[TestWith(['text', ['x'], HttpStatus::NoContent])]
    #[TestWith(['json', [[]], HttpStatus::NotModified])]
    #[TestWith(['error', ['x'], HttpStatus::Ok])]            // errors are >= 400
    #[TestWith(['error', ['x'], HttpStatus::Found])]
    #[TestWith(['redirect', ['/x'], HttpStatus::Ok])]        // redirects are 3xx...
    #[TestWith(['redirect', ['/x'], HttpStatus::NotModified])] // ...but not 304
    #[TestWith(['redirect', ['/x'], HttpStatus::NotFound])]
    #[TestWith(['clientRedirect', ['/x'], HttpStatus::Ok])]
    #[TestWith(['clientRedirect', ['/x'], HttpStatus::Found])]
    #[TestWith(['methodNotAllowed', [[]], HttpStatus::NotFound])]
    #[TestWith(['noContent', [], HttpStatus::Ok])]
    public function an_invalid_status_override_throws(string $method, array $args, HttpStatus $status): void
    {
        $this->expectException(WebError::class);
        $this->expectExceptionMessage("Status {$status->value} is not valid for single()->{$method}()");

        Response::single($status)->$method(...$args);
    }

    // ---- caller headers ----

    #[Test]
    public function caller_headers_are_added_to_the_response(): void
    {
        $response = Response::single(headers: ['Cache-Control' => ['no-store']])->html('x');

        $this->assertEquals(
            ['Cache-Control' => ['no-store'], 'Content-Type' => ['text/html; charset=utf-8']],
            $response->headers->list,
        );
    }

    #[Test]
    public function caller_cannot_override_the_methods_own_single_value_headers(): void
    {
        $html = Response::single(headers: ['Content-Type' => ['application/evil']])->html('x');
        $redirect = Response::single(headers: ['Location' => ['/elsewhere']])->redirect('/jobs');

        $this->assertSame(['text/html; charset=utf-8'], $html->headers[ResponseHeaders::ContentType]);
        $this->assertSame(['/jobs'], $redirect->headers[ResponseHeaders::Location]);
    }

    #[Test]
    public function caller_list_headers_are_appended_to_not_replaced(): void
    {
        $response = Response::single(headers: ['Allow' => ['OPTIONS']])->methodNotAllowed([HttpMethods::GET]);

        $this->assertSame(['OPTIONS', 'GET'], $response->headers[ResponseHeaders::Allow]);
    }

    #[Test]
    public function caller_headers_are_validated_too(): void
    {
        $this->expectException(WebError::class);
        Response::single(headers: ['Cache-Control' => ["x\r\nSet-Cookie: a=b"]])->html('x');
    }

    // ---- failures ----

    #[Test]
    public function json_throws_when_built_not_when_sent(): void
    {
        $this->expectException(JsonException::class);
        Response::single()->json(['bad' => "\xff"]); // invalid UTF-8
    }

    #[Test]
    #[TestWith(['redirect'])]
    #[TestWith(['clientRedirect'])]
    public function redirects_reject_a_target_that_could_split_the_header(string $method): void
    {
        $this->expectException(WebError::class);
        Response::single()->$method("/x\r\nSet-Cookie: session_token=evil");
    }

    #[Test]
    public function the_factory_can_be_reused(): void
    {
        $single = Response::single(HttpStatus::NotFound);

        $a = $single->html('a');
        $b = $single->json([]);

        $this->assertNotSame($a, $b);
        $this->assertSame(HttpStatus::NotFound, $a->status);
        $this->assertSame(HttpStatus::NotFound, $b->status);
    }

    #[Test]
    public function empty_requires_an_explicit_status(): void
    {
        $this->expectException(WebError::class);
        Response::single()->empty();
    }

    #[Test]
    #[TestWith([HttpStatus::Ok])]
    #[TestWith([HttpStatus::Created])]
    #[TestWith([HttpStatus::NoContent])]
    #[TestWith([HttpStatus::NotFound])]
    public function empty_sends_the_given_status_and_no_body(HttpStatus $status): void
    {
        $response = Response::single($status)->empty();

        $this->assertSame($status, $response->status);
        $this->assertSame([], $response->headers->list);
        $this->assertSame('', self::body($response));
    }

    #[Test]
    public function empty_keeps_caller_headers(): void
    {
        $response = Response::single(HttpStatus::Created, ['Location' => ['/jobs/42']])->empty();

        $this->assertSame(['Location' => ['/jobs/42']], $response->headers->list);
    }
}
