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
    error_reporting(0);
    ini_set('display_errors', 0);
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
