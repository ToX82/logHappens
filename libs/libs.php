<?php

/**
 * Initialization instructions
 *
 * @return void
 */
function init()
{
    include_once __DIR__ . "/utilities.php";
    include_once __DIR__ . "/paths.php";
    include_once __DIR__ . "/security.php";

    header('Content-type: text/html;charset=utf-8');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL ^ E_DEPRECATED);

    setting('theme');
    setting('refresh');
    setting('page-length');

    define('BASE_URL', rtrim(baseUrl(), '/') . "/");

    if (!is_file(ROOT . 'vendor/autoload.php')) {
        echo file_get_contents(ROOT . 'webroot/firstrun.html');
        die();
    }

    require_once ROOT . 'vendor/autoload.php';
}

/**
 * Detects the user's browser language
 *
 * @return string
 */
function getBrowserLanguage()
{
    return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

/**
 * Detects the user's full browser language
 *
 * @return string
 */
function getFullBrowserLanguage()
{
    return str_replace('-', '_', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5));
}

/**
 * Returns the user's language name (when available)
 *
 * @return string
 */
function getUserLanguage()
{
    $languages = [
        'nl' => 'Dutch',
        'fr' => 'French',
        'de' => 'German',
        'it' => 'Italian',
        'sp' => 'Spanish',
    ];

    $lang = getBrowserLanguage();
    return $languages[$lang] ?? 'English';
}

/**
 * Debug function
 *
 * @param mixed $var Variable to be printed (string or array)
 * @return void
 */
function debug($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
