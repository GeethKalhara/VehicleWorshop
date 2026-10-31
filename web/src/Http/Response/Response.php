<?php

declare(strict_types=1);

namespace Vwork\Web\Http\Response;

use Closure;
use Vwork\Shared\Collections\EnumList;
use Vwork\Web\WebError;
use Vwork\Web\Http\Cookies\HttpCookies;
use Vwork\Web\Http\Cookies\CookieSitePolicies;
use Vwork\Web\Http\Cookies\ResponseCookie;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpStatus;

/**
 * What goes out.
 *
 * Carries a status, headers, and a body — but doesn't write anything
 * itself. Instead it holds a single closure, `sender`, that knows how to
 * push this particular response to the client, whatever shape that
 * takes: a plain page, a file download, or a long-lived SSE stream. The
 * rest of the app never has to ask which kind it's dealing with.
 *
 * Built through one of two entry points, picked by how the body is
 * delivered:
 *
 *     Response::single(status, headers)->html($html)
 *     Response::stream(status, headers)->json($events)
 *
 * @author Senira <senirahan@gmail.com>
 */
final class Response
{
    /** @var EnumList<ResponseHeaders, list<string>> */
    public private(set) EnumList $headers;

    /** @var EnumList<HttpCookies, ResponseCookie> */
    public private(set) EnumList $cookies;

    /**
     * Every header goes through addHeader(), so the same checks apply
     * whether it was set here or added later.
     *
     * @param array<value-of<ResponseHeaders>, list<string>> $headers
     * @param Closure(): void $sender
     * @throws WebError if a header value is invalid
     */
    private function __construct(
        public private(set) HttpStatus $status,
        array $headers,
        private Closure $sender
    ) {
        /** @var EnumList<ResponseHeaders, list<string>> $emptyHeaders */
        $emptyHeaders = EnumList::of(ResponseHeaders::class);
        $this->headers = $emptyHeaders;

        /** @var EnumList<HttpCookies, ResponseCookie> $emptyCookies */
        $emptyCookies = EnumList::of(HttpCookies::class);
        $this->cookies = $emptyCookies;

        foreach ($headers as $name => $values) {
            foreach ($values as $value) {
                $this->addHeader(ResponseHeaders::from($name), $value);
            }
        }
    }

    /**
     * @internal for SingleResponses / StreamResponses only; everything
     * else goes through single() or stream().
     *
     * @param array<value-of<ResponseHeaders>, list<string>> $headers
     * @param Closure(): void $sender
     * @throws WebError if a header value is invalid
     */
    public static function build(HttpStatus $status, array $headers, Closure $sender): self
    {
        return new self($status, $headers, $sender);
    }

    /**
     * Responses whose whole body is known up front (or that have none).
     *
     * @param ?HttpStatus $status - null uses each method's default;
     *     an explicit one is validated by the method
     * @param array<value-of<ResponseHeaders>, list<string>> $headers - extra headers
     */
    public static function single(?HttpStatus $status = null, array $headers = []): SingleResponses
    {
        return new SingleResponses($status, $headers);
    }

    /**
     * Responses whose body is produced over time: SSE and file downloads.
     *
     * @param ?HttpStatus $status - null uses each method's default;
     *     an explicit one is validated by the method
     * @param array<value-of<ResponseHeaders>, list<string>> $headers - extra headers
     */
    public static function stream(?HttpStatus $status = null, array $headers = []): StreamResponses
    {
        return new StreamResponses($status, $headers);
    }

    public function changeStatus(HttpStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * List headers (Allow, Cache-Control, Vary) get $value appended;
     * every other header is replaced.
     *
     * @throws WebError if $value contains CR, LF or NUL (header injection)
     */
    public function addHeader(ResponseHeaders $header, string $value): self
    {
        if (strpbrk($value, "\r\n\0") !== false) {
            throw new WebError("Invalid value for {$header->value} header");
        }

        $values = $header->isList() ? [...($this->headers[$header] ?? []), $value] : [$value];
        $this->headers = $this->headers->with($header, $values);
        return $this;
    }

    public function rmHeader(ResponseHeaders $header): self
    {
        $this->headers = $this->headers->without($header);
        return $this;
    }

    /**
     * Queues a Set-Cookie line
     *
     * @throws WebError if $path is not an absolute path, or $maxAge is negative
     */
    public function addCookie(HttpCookies $name, string $value, string $path = '/', CookieSitePolicies $sameSite = CookieSitePolicies::Lax, ?int $maxAge = null): self
    {
        $this->cookies = $this->cookies->with(
            $name,
            new ResponseCookie($name, $value, $path, $sameSite, $maxAge)
        );
        return $this;
    }

    /**
     * Un-queues a line added earlier in THIS response.
     * The browser's own copy is untouched — that's expireCookie().
     */
    public function rmCookie(HttpCookies $name): self
    {
        $this->cookies = $this->cookies->without($name);
        return $this;
    }

    /**
     * Asks the browser to drop a cookie it holds, by sending an already-
     * expired one. $path must match what it was set with, or
     * the browser sees a different cookie and ignores this.
     */
    public function expireCookie(HttpCookies $name, string $path = '/'): self
    {
        return $this->addCookie($name, '', $path, maxAge: 0);
    }

    /**
     * 🔴 ⚠️ Writes to PHP's global output state. ⚠️ 🔴
     *
     * Everything upstream builds a Response as plain data; the actual
     * response emitting happens here.
     *
     * List headers go out as one comma-joined line (RFC 9110 §5.3);
     * every other header only ever holds one value.
     */
    public function send(bool $secure): void
    {
        http_response_code($this->status->value);

        foreach ($this->headers as $header => $values) {
            header(
                "{$header->value}: " . implode(', ', $values),
                replace: false
            );
        }

        foreach ($this->cookies as $cookie) {
            header(
                $cookie->toLine($secure),
                replace: false
            );
        }

        ($this->sender)();

        flush();
    }
}
