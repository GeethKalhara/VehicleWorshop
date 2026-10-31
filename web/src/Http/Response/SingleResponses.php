<?php

declare(strict_types=1);

namespace Vwork\Web\Http\Response;

use Closure;
use Vwork\Web\WebError;
use Vwork\Web\Http\Headers\ResponseHeaders;
use Vwork\Web\Http\HttpMethods;
use Vwork\Web\Http\HttpStatus;

/**
 * Responses whose whole body is known up front (or that have none).
 *
 * Obtained via Response::single(status, headers). A null status means
 * "use the method's default"; an explicit one is validated per method.
 */
final readonly class SingleResponses
{
    /**
     * @param array<value-of<ResponseHeaders>, list<string>> $headers
     */
    public function __construct(
        private ?HttpStatus $status,
        private array $headers,
    ) {
    }

    public function html(string $data): Response
    {
        return $this->encoded(Format::Html, $data, $this->resolve(HttpStatus::Ok, __FUNCTION__, self::bodyAllowed(...)));
    }

    public function text(string $data): Response
    {
        return $this->encoded(Format::Text, $data, $this->resolve(HttpStatus::Ok, __FUNCTION__, self::bodyAllowed(...)));
    }

    /**
     * Status and headers only; nothing is written as the body.
     * For when the status alone is the answer (e.g. 201 + Location, 202).
     */
    public function empty(): Response
    {
        if ($this->status === null) {
            throw new WebError('single()->empty() has no default status. pass one to single()');
        }
        return $this->finish($this->status, [], self::nothing(...));
    }

    /** @param array<string, mixed> $data */
    public function json(array $data): Response
    {
        return $this->encoded(Format::Json, $data, $this->resolve(HttpStatus::Ok, __FUNCTION__, self::bodyAllowed(...)));
    }

    // /** @param array<string, mixed> $data */
    // public function cbor(array $data): Response
    // {
    //     return $this->encoded(Format::Cbor, $data, $this->resolve(HttpStatus::Ok, __FUNCTION__, self::bodyAllowed(...)));
    // }

    public function error(string $msg = ''): Response
    {
        $status = $this->resolve(
            HttpStatus::InternalServerError,
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s->value >= 400,
        );
        return $this->encoded(Format::Text, $msg, $status);
    }

    /** HTTP redirect: 3xx + Location. fetch() follows it transparently. */
    public function redirect(string $path): Response
    {
        $status = $this->resolve(
            HttpStatus::Found,
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s->value >= 300 && $s->value < 400 && $s !== HttpStatus::NotModified,
        );
        return $this->finish($status, [ResponseHeaders::Location->value => [$path]], self::nothing(...));
    }

    /** Client-side full-page redirect: 204 + X-Redirect, for the front-end library. */
    public function clientRedirect(string $path): Response
    {
        $status = $this->resolve(
            HttpStatus::NoContent,
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s === HttpStatus::NoContent,
        );
        return $this->finish($status, [ResponseHeaders::XAttrRedirect->value => [$path]], self::nothing(...));
    }

    /** @param list<HttpMethods> $allowed */
    public function methodNotAllowed(array $allowed): Response
    {
        $status = $this->resolve(
            HttpStatus::MethodNotAllowed,
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s === HttpStatus::MethodNotAllowed,
        );
        return $this->finish(
            $status,
            [ResponseHeaders::Allow->value => array_map(static fn (HttpMethods $m): string => $m->value, $allowed)],
            self::nothing(...),
        );
    }

    public function noContent(): Response
    {
        $status = $this->resolve(
            HttpStatus::NoContent,
            __FUNCTION__,
            static fn (HttpStatus $s): bool => $s === HttpStatus::NoContent,
        );
        return $this->finish($status, [], self::nothing(...));
    }

    // ── helpers ────────────────────────────────────────────────

    private function encoded(Format $format, mixed $value, HttpStatus $status): Response
    {
        $body = $format->encode($value);

        return $this->finish(
            $status,
            [ResponseHeaders::ContentType->value => [$format->contentType()]],
            static function () use ($body): void {
                echo $body;
            },
        );
    }

    /**
     * Caller's headers go in first; the method's own are added after, so
     * single-value ones (Content-Type, Location) can't be overridden and
     * list ones (Allow, Vary) are appended.
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
     * @param Closure(HttpStatus): bool $allowed
     * @throws WebError on a status this method can't send
     */
    private function resolve(HttpStatus $default, string $method, Closure $allowed): HttpStatus
    {
        if ($this->status === null) {
            return $default;
        }

        if (!$allowed($this->status)) {
            throw new WebError("Status {$this->status->value} is not valid for single()->{$method}()");
        }

        return $this->status;
    }

    /** 1xx, 204 and 304 must not carry a body. */
    private static function bodyAllowed(HttpStatus $s): bool
    {
        // @phpstan-ignore greaterOrEqual.alwaysTrue
        return $s->value >= 200
            && $s !== HttpStatus::NoContent
            && $s !== HttpStatus::NotModified;
    }

    private static function nothing(): void
    {
    }
}
