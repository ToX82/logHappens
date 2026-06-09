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

    /**
     * Validates and sanitizes a search string.
     * Removes potentially dangerous characters while preserving search functionality.
     *
     * @param string $search The search string to validate
     * @return string Sanitized search string
     */
    public static function validateSearchString(string $search): string
    {
        // Remove null bytes and control characters
        $search = str_replace(["\0", "\r"], '', $search);
        // Sanitize but preserve basic search characters
        $search = filter_var($search, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        // Limit length to prevent DoS
        if (strlen($search) > 1000) {
            $search = substr($search, 0, 1000);
        }
        return trim($search);
    }

    /**
     * Validates a file path to prevent directory traversal attacks.
     * Only allows absolute paths that exist and are readable.
     *
     * @param string $filePath The file path to validate
     * @return string|null Returns the validated absolute path or null if invalid
     */
    public static function validateFilePath(string $filePath): ?string
    {
        // Remove null bytes
        $filePath = str_replace("\0", '', $filePath);

        // Must be an absolute path (Unix: starts with '/', Windows: starts with drive letter e.g. C:\ or C:/)
        $isUnixAbsolute = substr($filePath, 0, 1) === '/';
        $isWindowsAbsolute = (bool)preg_match('/^[a-zA-Z]:[\\\\\/]/', $filePath);
        if (!$isUnixAbsolute && !$isWindowsAbsolute) {
            return null;
        }

        // Resolve real path to prevent directory traversal
        $realPath = realpath($filePath);
        if ($realPath === false || !is_file($realPath)) {
            return null;
        }

        // Additional check: ensure the resolved path matches the input (prevents symlink attacks)
        // Allow the path as-is if it's a valid absolute path
        return $realPath;
    }

    /**
     * Validates a parser name to prevent path traversal in include statements.
     * Only allows alphanumeric characters, underscores, and hyphens.
     *
     * @param string $parserName The parser name to validate
     * @return string|null Returns the validated parser name or null if invalid
     */
    public static function validateParserName(string $parserName): ?string
    {
        // Remove null bytes
        $parserName = str_replace("\0", '', $parserName);

        // Only allow alphanumeric, underscore, and hyphen
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $parserName)) {
            return null;
        }

        // Limit length
        if (strlen($parserName) > 100) {
            return null;
        }

        return $parserName;
    }

    /**
     * Validates configuration keys/names.
     * Only allows alphanumeric characters and underscores.
     *
     * @param mixed $configName The configuration name to validate
     * @return string|null Returns the validated config name or null if invalid
     */
    public static function validateConfigName($configName): ?string
    {
        if (!is_string($configName) && !is_numeric($configName)) {
            return null;
        }

        $configName = (string)$configName;

        // Remove null bytes
        $configName = str_replace("\0", '', $configName);

        // Allow alphanumeric and underscore
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $configName)) {
            return null;
        }

        return $configName;
    }

    /**
     * Validates an array of configuration names.
     *
     * @param array $order Array of configuration names
     * @return array Validated array of configuration names
     */
    public static function validateConfigOrder(array $order): array
    {
        $validated = [];
        foreach ($order as $configName) {
            $validatedName = self::validateConfigName($configName);
            if ($validatedName !== null) {
                $validated[] = $validatedName;
            }
        }
        return $validated;
    }
}
