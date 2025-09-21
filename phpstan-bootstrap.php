<?php

// Define runtime constants for static analysis context
if (!defined('ROOT')) {
    define('ROOT', '/var/www/loghappens/');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/loghappens/');
}

// Minimal autoload to resolve classes
$autoload = __DIR__ . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}
