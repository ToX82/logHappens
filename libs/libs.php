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

    setting('theme');
    setting('refresh');
    setting('page-length');

    define('BASE_URL', baseUrl() . "/");

    if (!is_file(ROOT . 'vendor/autoload.php')) {
        echo file_get_contents(ROOT . 'webroot/firstrun.html');
        die;
    }
    require_once ROOT . 'vendor/autoload.php';

    error_reporting(E_ALL ^ E_DEPRECATED);
}

/**
 * Detects the user's browser language
 *
 * @return string
 */
function getBrowserLanguage()
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    return $lang;
}

/**
 * Detects the user's browser language
 *
 * @return string
 */
function getFullBrowserLanguage()
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
    $lang = str_replace('-', '_', $lang);

    return $lang;
}

/**
 * Returns the user's language name (when available)
 *
 * @return string
 */
function getUserLanguage()
{
    $lang = getBrowserLanguage();
    switch ($lang) {
        case 'nl':
            return 'Dutch';
        case 'fr':
            return 'French';
        case 'de':
            return 'German';
        case 'it':
            return 'Italian';
        case 'sp':
            return 'Spanish';
        default:
            return 'English';
    }
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
