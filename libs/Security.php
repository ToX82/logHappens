<?php

declare(strict_types=1);

namespace Libs;

/**
 * Security-related helpers.
 */
class Security
{
    /**
     * Parse a GET variable returning a clean string.
     *
     * @param int|string $key
     * @return string
     */
    public static function filterString($key): string
    {
        $params = UrlHelper::splitQueryParams();
        return (string)filter_var($params[$key] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * Parse a GET variable returning a clean int value.
     *
     * @param int|string $key
     * @return int
     */
    public static function filterInt($key): int
    {
        $params = UrlHelper::splitQueryParams();
        return (int)filter_var($params[$key] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    }
}
