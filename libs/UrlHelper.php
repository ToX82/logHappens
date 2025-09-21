<?php

declare(strict_types=1);

namespace Libs;

/**
 * URL and request related helpers.
 */
class UrlHelper
{
    /**
     * Splits the GET parameters into an array.
     *
     * @return array
     */
    public static function splitQueryParams(): array
    {
        // Prefer PATH_INFO when available
        if (!empty($_SERVER['PATH_INFO'])) {
            $path = (string)$_SERVER['PATH_INFO'];
        } else {
            // Fallback to REQUEST_URI path portion
            $requestUri = (string)($_SERVER['REQUEST_URI'] ?? '');
            $path = (string)parse_url($requestUri, PHP_URL_PATH);
            // Remove script directory and script name
            $scriptDir = rtrim((string)dirname((string)($_SERVER['SCRIPT_NAME'] ?? '')), '/');
            if ($scriptDir !== '' && str_starts_with($path, $scriptDir)) {
                $path = substr($path, strlen($scriptDir));
            }
            $path = str_replace(['/index.php', '/ajax.php'], '', $path);
        }

        // Remove base application path if present (e.g. '/loghappens')
        $basePath = rtrim((string)(parse_url(self::baseUrl(), PHP_URL_PATH) ?? ''), '/');
        if ($basePath !== '') {
            // Ensure both have leading slash for consistent comparison
            $normalizedPath = '/' . ltrim($path, '/');
            $normalizedBase = '/' . ltrim($basePath, '/');
            if ($normalizedPath === $normalizedBase) {
                $path = '';
            } elseif (str_starts_with($normalizedPath, $normalizedBase . '/')) {
                $path = substr($normalizedPath, strlen($normalizedBase));
            }
        }

        $path = trim($path, '/');
        if ($path === '') {
            return [];
        }

        return explode('/', $path);
    }

    /**
     * Checks if a GET variable exists in the parameters.
     *
     * @param string $name
     * @return bool
     */
    public static function isPage(string $name): bool
    {
        $params = self::splitQueryParams();
        return in_array($name, $params, true);
    }

    /**
     * Redirects to a specified destination or reloads the current page.
     *
     * @param string $destination
     * @return void
     */
    public static function reload(string $destination = ''): void
    {
        if (PHP_SAPI === 'cli') {
            // Avoid header output in CLI context
            if ($destination === '') {
                $destination = self::currentUrl();
            }
            echo "Redirect to: {$destination}\n";
            return;
        }

        if (ob_get_contents()) {
            ob_end_clean();
            ob_start();
        }
        if ($destination === '') {
            $destination = self::currentUrl();
        }
        if (strpos($destination, "/") === 0) {
            $destination = BASE_URL . $destination;
        }
        header('Location: ' . $destination);
        exit;
    }

    /**
     * Returns the current full URL.
     *
     * @return string
     */
    public static function currentUrl(): string
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            return BASE_URL ?: '/';
        }
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = (string)$_SERVER['HTTP_HOST'];
        $uri = (string)($_SERVER['REQUEST_URI'] ?? '/');
        return $scheme . '://' . $host . $uri;
    }

    /**
     * Returns the base URL.
     *
     * @return string
     */
    public static function baseUrl(): string
    {
        // Allow override via environment for non-web contexts
        $envBase = (string)(getenv('APP_BASE_URL') ?: '');
        if ($envBase !== '') {
            return rtrim($envBase, '/');
        }

        if (!isset($_SERVER['HTTP_HOST'])) {
            // Sensible default for CLI
            return 'http://localhost/loghappens';
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $script = (string)($_SERVER['SCRIPT_NAME'] ?? '/');
        $url = $scheme . $_SERVER['HTTP_HOST'] . $script;
        $url = str_replace('/webroot/index.php', '', $url);
        $url = rtrim($url, '/');

        return $url;
    }

    /**
     * Builds a complete URL with specified parameters.
     *
     * @param string $params
     * @return string
     */
    public static function buildUrl(string $params): string
    {
        return BASE_URL . $params;
    }

    /**
     * Builds an asset URL with cache busting.
     *
     * @param string $asset
     * @return string
     */
    public static function buildAssetUrl(string $asset): string
    {
        $assetUrl = rtrim(BASE_URL, '/') . '/' . ltrim($asset, '/');
        $assetPath = ROOT . ltrim($asset, '/');
        $mtime = is_file($assetPath) ? (int)filemtime($assetPath) : time();
        return $assetUrl . "?" . $mtime;
    }

    /**
     * Checks if the passed page matches with the current URL and returns the specified class if it does.
     *
     * @param string $page
     * @param string $class
     * @return string
     */
    public static function checkPage(string $page, string $class): string
    {
        if (strpos(self::getPageParams(), $page) !== false) {
            return $class;
        }

        return '';
    }

    /**
     * Returns the current URL parameters.
     *
     * @return string
     */
    public static function getPageParams(): string
    {
        $path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
        $params = str_replace($path, '', $_SERVER['REQUEST_URI']);

        return $params;
    }
}
