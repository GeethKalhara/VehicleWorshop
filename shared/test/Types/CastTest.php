<?php

declare(strict_types=1);

namespace Vwork\Shared\Test\Types;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Vwork\Shared\Exception\VworkError;
use Vwork\Shared\Types\Cast;

final class CastTest extends TestCase
{
    #[Test]
    #[TestWith(['hello'])]
    #[TestWith([''])]
    #[TestWith(['0'])]
    public function string_returns_strings_unchanged(string $value): void
    {
        $this->assertSame($value, Cast::string($value));
    }

    #[Test]
    #[TestWith([42])]
    #[TestWith([3.14])]
    #[TestWith([true])]
    #[TestWith([null])]
    #[TestWith([[]])]
    public function string_throws_for_non_strings(mixed $value): void
    {
        $this->expectException(VworkError::class);
        Cast::string($value);
    }

    #[Test]
    public function string_throws_for_objects(): void
    {
        $this->expectException(VworkError::class);
        Cast::string(new \stdClass());
    }

    #[Test]
    public function string_error_message_names_the_actual_type(): void
    {
        $this->expectException(VworkError::class);
        $this->expectExceptionMessageMatches('/int/');
        Cast::string(42);
    }

    #[Test]
    public function stringMap_returns_an_all_string_array_unchanged(): void
    {
        $input = ['status' => 'open', 'sort' => 'created_at'];

        $this->assertSame($input, Cast::stringMap($input));
    }

    #[Test]
    public function stringMap_accepts_an_empty_array(): void
    {
        $this->assertSame([], Cast::stringMap([]));
    }

    #[Test]
    public function stringMap_converts_integer_keys_to_strings(): void
    {
        // PHP turns numeric-string array keys into ints, so a query like
        // "?0=a&1=b" arrives with int keys — they still cast to strings
        $this->assertSame(['0' => 'a', '1' => 'b'], Cast::stringMap([0 => 'a', 1 => 'b']));
    }

    #[Test]
    public function stringMap_throws_when_any_value_is_not_a_string(): void
    {
        $this->expectException(VworkError::class);
        Cast::stringMap(['status' => 'open', 'count' => 3]);
    }

    #[Test]
    public function stringMap_throws_for_nested_arrays(): void
    {
        // this is the real $_GET case: "?tags[]=a&tags[]=b" produces
        // ['tags' => ['a', 'b']], which stringMap deliberately rejects
        $this->expectException(VworkError::class);
        Cast::stringMap(['tags' => ['a', 'b']]);
    }

    #[Test]
    public function stringListMap_returns_single_values_unchanged(): void
    {
        $input = ['plate' => 'CAB-1234', 'notes' => ''];

        $this->assertSame($input, Cast::stringListMap($input));
    }

    #[Test]
    public function stringListMap_returns_lists_unchanged(): void
    {
        // "?services[]=3&services[]=7" arrives as ['services' => ['3', '7']]
        $input = ['services' => ['3', '7']];

        $this->assertSame($input, Cast::stringListMap($input));
    }

    #[Test]
    public function stringListMap_keeps_single_and_list_fields_distinct(): void
    {
        $input = ['plate' => 'CAB-1234', 'services' => ['3']];

        // a one-item list stays a list; it must not collapse to a string
        $this->assertSame($input, Cast::stringListMap($input));
    }

    #[Test]
    public function stringListMap_accepts_an_empty_array(): void
    {
        $this->assertSame([], Cast::stringListMap([]));
    }

    #[Test]
    public function stringListMap_accepts_an_empty_list(): void
    {
        // PHP's parser never produces this, but parse_str callers or tests might
        $this->assertSame(['tags' => []], Cast::stringListMap(['tags' => []]));
    }

    #[Test]
    public function stringListMap_converts_integer_keys_to_strings(): void
    {
        $this->assertSame(['0' => 'a', '1' => ['b']], Cast::stringListMap([0 => 'a', 1 => ['b']]));
    }

    #[Test]
    public function stringListMap_throws_for_keyed_arrays(): void
    {
        // "?vehicle[plate]=X" arrives as ['vehicle' => ['plate' => 'X']]
        $this->expectException(VworkError::class);
        Cast::stringListMap(['vehicle' => ['plate' => 'X']]);
    }

    #[Test]
    public function stringListMap_throws_for_explicitly_indexed_lists_with_gaps(): void
    {
        // "?tags[1]=a" arrives as ['tags' => [1 => 'a']], which is not a list
        $this->expectException(VworkError::class);
        Cast::stringListMap(['tags' => [1 => 'a']]);
    }

    #[Test]
    public function stringListMap_throws_for_nested_lists(): void
    {
        // "?tags[][]=a" arrives as ['tags' => [['a']]]
        $this->expectException(VworkError::class);
        Cast::stringListMap(['tags' => [['a']]]);
    }

    #[Test]
    #[TestWith([42])]
    #[TestWith([null])]
    #[TestWith([true])]
    public function stringListMap_throws_for_non_string_values(mixed $value): void
    {
        $this->expectException(VworkError::class);
        Cast::stringListMap(['field' => $value]);
    }

    #[Test]
    #[TestWith([42])]
    #[TestWith([null])]
    #[TestWith([true])]
    public function stringListMap_throws_for_non_string_list_items(mixed $item): void
    {
        $this->expectException(VworkError::class);
        Cast::stringListMap(['field' => ['ok', $item]]);
    }

    #[Test]
    public function stringListMap_error_message_names_the_field(): void
    {
        $this->expectException(VworkError::class);
        $this->expectExceptionMessageMatches('/vehicle/');
        Cast::stringListMap(['vehicle' => ['plate' => 'X']]);
    }
}
