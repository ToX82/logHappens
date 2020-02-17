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
 * Debug function
 *
 * @param mixed $var Variable to be printed (string or array)
 * 
 * @return void
 */
function debug($var)
{
    echo "<pre>";
        print_r($var);
    echo "</pre>";
}
