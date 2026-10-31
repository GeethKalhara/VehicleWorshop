<?php

declare(strict_types=1);

namespace Vwork\Web\Test\Unit\Http\Response;

use JsonException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Vwork\Web\Http\Response\Format;
use Vwork\Web\WebError;

final class FormatTest extends TestCase
{
    #[Test]
    #[TestWith([Format::Html, 'text/html; charset=utf-8'])]
    #[TestWith([Format::Text, 'text/plain; charset=utf-8'])]
    #[TestWith([Format::Json, 'application/json; charset=utf-8'])]
    // #[TestWith([Format::Cbor, 'application/cbor'])]
    public function each_format_names_its_content_type(Format $format, string $type): void
    {
        $this->assertSame($type, $format->contentType());
    }

    #[Test]
    #[TestWith([Format::Html, '<p>x</p>'])]
    #[TestWith([Format::Html, ''])]
    #[TestWith([Format::Text, "a\nb"])]
    #[TestWith([Format::Text, '0'])] // falsy string still passes through
    public function html_and_text_pass_strings_through_untouched(Format $format, string $value): void
    {
        $this->assertSame($value, $format->encode($value));
    }

    #[Test]
    #[TestWith([Format::Html, ['x']])]
    #[TestWith([Format::Html, 1])]
    #[TestWith([Format::Text, null])]
    public function html_and_text_reject_anything_but_a_string(Format $format, mixed $value): void
    {
        $this->expectException(WebError::class);
        $this->expectExceptionMessage("Format::{$format->name} expects a string");
        $format->encode($value);
    }

    /**
     * @param array<array-key, mixed> $value
     */
    #[Test]
    #[TestWith([['a' => 1], '{"a":1}'])]
    #[TestWith([[], '[]'])]                                              // empty PHP array is a JSON list
    #[TestWith([['path' => '/jobs/42'], '{"path":"/jobs/42"}'])]         // slashes unescaped
    #[TestWith([['name' => 'රසීද'], '{"name":"රසීද"}'])]                 // unicode unescaped
    #[TestWith([['s' => "a\u{2028}b"], "{\"s\":\"a\u{2028}b\"}"])]       // line terminators unescaped
    #[TestWith([['s' => "a\nb"], '{"s":"a\nb"}'])]                       // real newlines still escaped
    public function json_encodes_with_the_project_flags(array $value, string $expected): void
    {
        $this->assertSame($expected, Format::Json->encode($value));
    }

    #[Test]
    public function json_throws_instead_of_returning_false(): void
    {
        $this->expectException(JsonException::class);
        Format::Json->encode(['bad' => "\xff"]); // invalid UTF-8
    }
}
