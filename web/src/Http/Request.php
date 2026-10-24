<?php

declare(strict_types=1);

namespace Vwork\Web\Http;

use RequestParseBodyException;
use Vwork\Shared\Collections\EnumList;
use Vwork\Shared\Types\Cast;
use Vwork\Web\Http\Cookies\HttpCookies;
use Vwork\Web\WebException;
use Vwork\Web\Http\Headers\RequestHeaders;
use Vwork\Web\WebError;

/**
 * What came in.
 *
 * Everything the app knows about what's being asked of it: method, path,
 * headers, and whatever the client sent along — query params, form
 * fields, uploaded files. Form data and files are read out at the very
 * moment the request is built from PHP's globals, because PHP only lets
 * you read the multipart body once — miss that window and it's gone.
 *
 * @author Senira <senirahan@gmail.com>
 */
final readonly class Request
{
    /**
     * @param EnumList<RequestHeaders, list<string>> $headers
     * @param EnumList<HttpCookies, string> $cookies
     * @param array<string, string|list<string>> $query
     * @param array<string, string|list<string>> $formData
     * @param array<string, UploadedFile|list<UploadedFile>> $files
     */
    private function __construct(
        public HttpMethods $method,
        public string $path,
        public EnumList $headers,
        public EnumList $cookies,
        public array $query,
        public string $body,
        public array $formData,
        public array $files,
        public string $ip,
    ) {
    }

    /**
     * @param array<string|int, mixed> $server $_SERVER, passed in
     * @return EnumList<RequestHeaders, list<string>>
     */
    private static function extractHeaders(array $server): EnumList
    {
        /** @var EnumList<RequestHeaders, list<string>> */
        $list = EnumList::of(RequestHeaders::class);

        foreach (RequestHeaders::serverKeyMap() as $key => $header) {
            if (!isset($server[$key])) {
                continue;
            }

            $raw = Cast::string($server[$key]);
            $values = $header->isList() ? explode(',', $raw) : [$raw];

            $acc = [];
            foreach ($values as $value) {
                $value = trim($value);
                if ($value !== '') {
                    $acc[] = $value;          // simpler than [...$acc, $value]
                }
            }

            if ($acc !== []) {
                $list = $list->with($header, $acc);
            }
        }

        return $list;
    }

    /**
     * @param EnumList<RequestHeaders, list<string>> $headers
     * @return EnumList<HttpCookies, string>
     */
    private static function extractCookies(EnumList $headers): EnumList
    {
        /** @var string */
        $raw = $headers[RequestHeaders::Cookie][0] ?? '';

        /** @var EnumList<HttpCookies, string> */
        $list = EnumList::of(HttpCookies::class);

        foreach (explode(';', $raw) as $pair) {
            [$name, $value] = array_pad(explode('=', trim($pair), 2), 2, '');
            // unknown names are ignored; the enum is the allowlist
            if (($key = HttpCookies::tryFrom($name)) !== null) {
                $list = $list->with($key, rawurldecode($value));
            }
        }

        return $list;
    }

    /**
     * Normalises $_FILES (or request_parse_body()'s files) to the same shape as formData:
     *   `photo`    → UploadedFile
     *   `photos[]` → list<UploadedFile>
     *
     * @param array<mixed, mixed> $rawFiles
     * @return array<string, UploadedFile|list<UploadedFile>>
     */
    private static function extractFiles(array $rawFiles): array
    {
        $acc = [];

        /**
         * @var string $field
         * @var array{
         *    name: list<string>,
         *    tmp_name: list<string>,
         *    type: list<string>,
         *    size: list<int>,
         *    error: list<int>
         * } | array{
         *    name: string,
         *    tmp_name: string,
         *    type: string,
         *    size: int,
         *    error: int
         * } $fileData
         */
        foreach ($rawFiles as $field => $fileData) {
            if (is_array($fileData['name'])) {
                $list = [];
                foreach ($fileData['name'] as $index => $name) {
                    $list[] = UploadedFile::fromMultiArray($fileData, $index);
                }
                $acc[$field] = $list;
            } else {
                $acc[$field] = UploadedFile::fromSingleArray($fileData);
            }
        }
        return $acc;
    }

    /**
     * 🔴 ⚠️ Reads from PHP's superglobals. ⚠️ 🔴
     *
     * Everything downstream works off the Request this builds. Reaching
     * for $_SERVER/$_GET/$_POST/$_FILES elsewhere means the data belongs
     * on Request instead.
     *
     * @throws WebException if the method isn't one HttpMethods knows
     * @throws WebError on bad requests that we do not support
     */
    public static function fromGlobals(): self
    {
        $methodString = strtoupper(Cast::string($_SERVER['REQUEST_METHOD']));
        $method = HttpMethods::tryFrom($methodString);
        if ($method === null) {
            throw new WebException("Unsupported HTTP method: {$methodString}");
        }

        // php doesn't automaticaly populate PUT PATCH requests to $_POST & $_FILES
        $post = [];
        $files = [];
        try {
            [$post, $files] = match ($method) {
                HttpMethods::POST => [$_POST, $_FILES],
                HttpMethods::PUT,
                HttpMethods::PATCH => request_parse_body(['post_max_size' => '10M', 'upload_max_filesize' => '10M',]),
                default => [[], []]
            };
        } catch (RequestParseBodyException $e) {
            throw new WebError('Wrong fucking media type', $e);
        }

        // body, formData and files all get captured here together: PHP eats
        // the multipart stream before userland runs, so php://input is empty
        // for uploads and there's no second chance at any of it
        $body = file_get_contents('php://input');
        if ($body === false) {
            $body = '';
        }

        $headers = self::extractHeaders($_SERVER);

        return new self(
            method: $method,
            body: $body,
            headers: $headers,
            cookies: self::extractCookies($headers),
            files: self::extractFiles($files),
            ip: Cast::string($_SERVER['REMOTE_ADDR']),
            path: explode('?', Cast::string($_SERVER['REQUEST_URI']), 2)[0],
            query: Cast::stringListMap($_GET),
            formData: Cast::stringListMap($post),
        );
    }
}
