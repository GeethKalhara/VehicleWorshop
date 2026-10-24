<?php

declare(strict_types=1);

namespace Vwork\Shared\Types;

use Vwork\Shared\Exception\VworkError;

/**
 * Narrows mixed values to concrete types, throwing when the value isn't
 * what the caller claims. For the boundaries where PHP hands back mixed
 * (superglobals, getenv, json_decode) and static analysis needs proof.
 */
final class Cast
{
    /**
     * @throws VworkError when $value isn't a string
     */
    public static function string(mixed $value): string
    {
        if (!is_string($value)) {
            throw new VworkError('Expected string, got ' . get_debug_type($value));
        }
        return $value;
    }

    /**
     * @param array<mixed, mixed> $values
     * @return array<string, string>
     * @throws VworkError when any value isn't a string
     */
    public static function stringMap(array $values): array
    {
        $result = [];
        foreach ($values as $key => $value) {
            $result[(string) $key] = self::string($value);
        }
        return $result;
    }

    /**
     * Validates PHP-parsed form or query data ($_GET, $_POST, parse_str output).
     * Each field is either a single string (`name`) or a list of strings (`name[]`).
     * Nested or keyed arrays (`name[key]`, `name[][]`) are rejected.
     *
     * @param array<mixed, mixed> $values
     * @return array<string, string|list<string>>
     * @throws VworkError when a field is neither a string nor a list of strings
     */
    public static function stringListMap(array $values): array
    {
        $result = [];
        foreach ($values as $key => $value) {
            $name = (string) $key;

            if (is_array($value)) {
                if (!array_is_list($value)) {
                    throw new VworkError("Field '{$name}' must be a value or a list, not keyed or nested");
                }

                $list = [];
                foreach ($value as $item) {
                    $list[] = self::string($item);
                }
                $result[$name] = $list;

            } else {
                $result[$name] = self::string($value);
            }
        }
        return $result;
    }
}
