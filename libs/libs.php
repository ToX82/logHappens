<?php
init();
function init()
{
    header('Content-type: text/html;charset=utf-8');
    session_start();

    if (!isset($_SESSION['pagelength'])) {
        $_SESSION['pagelength'] = 5;
    }
}

/*
* PRINT_R WRAPPED IN A <PRE> TAG
*/
function debug($array)
{
    echo '<pre>';
        print_r($array);
    echo "</pre>\n";
    return ($array);
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

function filterEmail($name)
{
    $name = filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING);
    return str_replace(" ", "+", $name);
}

function filterInt($name)
{
    return filter_input(INPUT_GET, $name, FILTER_SANITIZE_NUMBER_INT);
}

function filterRaw($name)
{
    return filter_input(INPUT_GET, $name, FILTER_UNSAFE_RAW);
}

function checkExistPost($name)
{
    return isset($_POST[$name]);
}
function filterStringPost($name)
{
    return filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING);
}

function filterIntPost($name)
{
    return filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_INT);
}

function filterRawPost($name)
{
    return filter_input(INPUT_POST, $name, FILTER_UNSAFE_RAW);
}

function filterArray($name)
{
    $clean = [];
    foreach ($name as $key => $item) {
        $clean[$key] = filter_var($item);
    }
    return $clean;
}
function filterFullArray($name)
{
    return filter_var_array($name);
}
