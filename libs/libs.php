<?php
include("config.php");

/*
* Initial configurations
*/
header("Content-type: text/html;charset=utf-8");
session_start();

if (!isset($_SESSION["pagelength"])) {
    $_SESSION["pagelength"] = $pagelength;
}

/*
* DATA SANITIZATION
*/
function checkExist($name)
{
    return isset($_GET[$name]);
}

function filterString($name)
{
    return filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING);
}

function filterInt($name)
{
    return filter_input(INPUT_GET, $name, FILTER_SANITIZE_NUMBER_INT);
}

function redirect($destination)
{
    header("Refresh:0; url=" . $destination);
}
