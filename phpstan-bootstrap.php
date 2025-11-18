<?php

// Define runtime constants for static analysis context
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

if (!defined('BASE_URL')) {
    define('BASE_URL', rtrim(Libs\UrlHelper::baseUrl(), '/') . "/");
}

// Minimal autoload to resolve classes
$autoload = __DIR__ . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}
