<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Unit\Http\Response;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Vwork\Web\Http\Cookies\CookieSitePolicies;
use Vwork\Web\Http\Cookies\HttpCookies;
use Vwork\Web\Http\Cookies\ResponseCookie;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpStatus;
use Vwork\Web\Http\Response\Response;
use Vwork\Web\Http\Response\SingleResponses;
use Vwork\Web\Http\Response\StreamResponses;
use Vwork\Web\WebError;

/**
 * Response's own behaviour: entry points, build(), headers, cookies, send().
 * What each kind of response contains is covered by SingleResponsesTest
 * and StreamResponsesTest; Set-Cookie rendering by ResponseCookieTest.
 */
final class ResponseTest extends TestCase
{
    private const array HTML = ['Content-Type' => ['text/html; charset=utf-8']];

    // ---- entry points ----

    #[Test]
    public function single_and_stream_hand_out_their_factories(): void
    {
        $this->assertInstanceOf(SingleResponses::class, Response::single());
        $this->assertInstanceOf(StreamResponses::class, Response::stream());
    }

    // ---- build ----

    #[Test]
    public function build_runs_the_sender_only_on_send(): void
    {
        $calls = 0;
        $response = Response::build(
            HttpStatus::Created,
            ['Content-Type' => ['text/plain; charset=utf-8']],
            static function () use (&$calls): void {
                $calls++;
                echo 'raw';
            },
        );

        $this->assertSame(0, $calls);
        $this->assertSame(HttpStatus::Created, $response->status);
        $this->assertSame(['Content-Type' => ['text/plain; charset=utf-8']], $response->headers->list);

        $this->expectOutputString('raw');
        $response->send(true);
        $this->assertSame(1, $calls);
    }

    #[Test]
    #[TestWith(["/x\r\nSet-Cookie: session_token=evil"])]
    #[TestWith(["/x\nY: z"])]
    #[TestWith(["/x\0"])]
    public function build_rejects_a_header_value_that_could_split_the_header(string $value): void
    {
        $this->expectException(WebError::class);
        Response::build(HttpStatus::Found, ['Location' => [$value]], static fn () => null);
    }

    // ---- status ----

    #[Test]
    public function change_status_mutates_in_place(): void
    {
        $response = Response::single()->text('x');

        $this->assertSame($response, $response->changeStatus(HttpStatus::Conflict));
        $this->assertSame(HttpStatus::Conflict, $response->status);
    }

    // ---- headers ----

    #[Test]
    public function add_and_rm_header_mutate_in_place(): void
    {
        $response = Response::single()->html('x');

        $this->assertSame($response, $response->addHeader(ResponseHeaders::CacheControl, 'no-store'));
        $this->assertSame(['no-store'], $response->headers[ResponseHeaders::CacheControl]);

        $this->assertSame($response, $response->rmHeader(ResponseHeaders::CacheControl));
        $this->assertSame(self::HTML, $response->headers->list);
    }

    #[Test]
    public function list_headers_append_and_others_replace(): void
    {
        $response = Response::single()->html('x')
            ->addHeader(ResponseHeaders::Vary, 'Accept')
            ->addHeader(ResponseHeaders::Vary, 'Cookie')
            ->addHeader(ResponseHeaders::ContentType, 'text/plain');

        $this->assertSame(['Accept', 'Cookie'], $response->headers[ResponseHeaders::Vary]);
        $this->assertSame(['text/plain'], $response->headers[ResponseHeaders::ContentType]);
    }

    #[Test]
    public function add_header_rejects_crlf(): void
    {
        $this->expectException(WebError::class);
        Response::single()->noContent()->addHeader(ResponseHeaders::Location, "/x\r\nX: y");
    }

    // ---- cookies ----

    #[Test]
    public function cookie_methods_queue_and_unqueue_cookies(): void
    {
        $response = Response::single()->noContent();

        $this->assertSame($response, $response->addCookie(HttpCookies::SessionToken, 'abc'));
        $this->assertSame($response, $response->addCookie(HttpCookies::RefreshToken, 'xyz', path: '/auth'));
        $this->assertSame($response, $response->rmCookie(HttpCookies::RefreshToken));
        $this->assertSame($response, $response->expireCookie(HttpCookies::RefreshToken, '/auth'));

        $this->assertEquals([
            'session_token' => new ResponseCookie(HttpCookies::SessionToken, 'abc'),
            'refresh_token' => new ResponseCookie(HttpCookies::RefreshToken, '', '/auth', maxAge: 0),
        ], $response->cookies->list);
        $this->assertSame([], $response->headers->list); // cookies never leak into the header list
    }

    #[Test]
    public function add_cookie_stores_every_attribute(): void
    {
        $response = Response::single()->noContent()->addCookie(
            HttpCookies::RefreshToken,
            'xyz',
            path: '/auth',
            sameSite: CookieSitePolicies::Strict,
            maxAge: 3600,
        );

        $this->assertEquals(
            ['refresh_token' => new ResponseCookie(HttpCookies::RefreshToken, 'xyz', '/auth', CookieSitePolicies::Strict, 3600)],
            $response->cookies->list,
        );
    }

    #[Test]
    public function adding_a_cookie_again_replaces_it(): void
    {
        $response = Response::single()->noContent()
            ->addCookie(HttpCookies::SessionToken, 'first', maxAge: 3600)
            ->addCookie(HttpCookies::SessionToken, 'second');

        $this->assertEquals(
            ['session_token' => new ResponseCookie(HttpCookies::SessionToken, 'second')],
            $response->cookies->list,
        );
    }

    #[Test]
    #[TestWith(['/a;b'])]         // would start a new attribute
    #[TestWith(['/a,b'])]
    #[TestWith(['/a b'])]
    #[TestWith(["/a\r\nX: y"])]   // would split the header
    #[TestWith(["/a\0"])]
    #[TestWith(['auth'])]         // must start with /
    #[TestWith([''])]
    public function add_cookie_rejects_a_path_that_could_inject_attributes(string $path): void
    {
        $this->expectException(WebError::class);
        Response::single()->noContent()->addCookie(HttpCookies::SessionToken, 'x', path: $path);
    }

    #[Test]
    public function add_cookie_rejects_a_negative_max_age(): void
    {
        $this->expectException(WebError::class);
        Response::single()->noContent()->addCookie(HttpCookies::SessionToken, 'x', maxAge: -1);
    }
}
