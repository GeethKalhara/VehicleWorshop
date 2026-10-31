<?php

declare(strict_types=1);

namespace Vwork\Web\Http\Response;

use Vwork\Web\WebError;

/**
 * How a value becomes bytes, and what that's called.
 *
 * Independent of delivery: SingleResponses sends one encoded value,
 * StreamResponses encodes each event's payload with the same case.
 */
enum Format
{
    case Html;
    case Text;
    case Json;
    // case Cbor;

    public function contentType(): string
    {
        return match ($this) {
            self::Html => 'text/html; charset=utf-8',
            self::Text => 'text/plain; charset=utf-8',
            self::Json => 'application/json; charset=utf-8',
            // self::Cbor => 'application/cbor',
        };
    }

    /**
     * @throws WebError if $value isn't something this format encodes
     * @throws \JsonException on JSON encoding failure
     */
    public function encode(mixed $value): string
    {
        return match ($this) {
            self::Html, self::Text => is_string($value)
                ? $value
                : throw new WebError("Format::{$this->name} expects a string"),
            self::Json => json_encode(
                $value,
                JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS
            ),
            // self::Cbor => cbor_encode($value, CBOR_TEXT | CBOR_KEY_TEXT),
        };
    }
}
