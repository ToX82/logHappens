<?php
define('BASE_PATH', basePath() . "/");
define('BASE_URL', baseUrl() . "/");

require_once BASE_PATH . 'vendor/autoload.php';

/**
 * Check if a GET variable exists
 *
 * @param string $name GET Variable's name
 * 
 * @return string variable's value
 */
function isPage($name)
{
    global $params;
    return in_array($name, $params);
}

/**
 * Splits the GET parameters into an array
 *
 * @return array
 */
function splitQueryParams()
{
    list($params) = array_keys($_GET);
    $params = trim($params, "/");
    $params = explode("/", $params);

    return $params;
}

/**
 * REDIRECT OR RELOAD
 *
 * @param string $destination Destinazione
 * 
 * @return void
 */
function reload($destination = '')
{
    if (ob_get_contents()) {
        ob_end_clean();
        ob_start();
    }
    if ($destination == '') {
        $destination = currentUrl();
    }
    if (strpos($destination, "/") == 0) {
        $destination = BASE_URL . $destination;
    }
    header('Location: ' . $destination);
    echo "<meta http-equiv='refresh' content=\"0;URL='{$destination}'\">";
    die;
}

/**
 * RETURNS THE CURRENT FULL URL
 *
 * @return string
 */
function currentUrl()
{
    return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

/**
 * RETURNS THE CURRENT BASE URL
 *
 * @return string
 */
function basePath()
{
    $return = $_SERVER['SCRIPT_FILENAME'];
    $return = str_replace(basename($return), '', $return);

    return $return;
}

/**
 * RETURNS THE CURRENT BASE URL
 *
 * @return string
 */
function baseUrl()
{
    $path = str_replace("/" . basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);

    return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$path}";
}

/**
 * Builds a complete url
 *
 * @param string $params Desired url parameters
 * 
 * @return string
 */
function buildUrl($params)
{
    return BASE_URL . $params;
}

/**
 * Builds an asset url
 *
 * @param string $asset Desired asset url
 * 
 * @return string
 */
function buildAssetUrl($asset)
{
    $assetUrl = BASE_URL . $asset;
    $assetPath = BASE_PATH . $asset;
    return $assetUrl . "?" . filemtime($assetPath);
}

/**
 * CHECK IF THE PASSED PAGE MATCHES WITH THE CURRENT URL
 *
 * @param string $page  Url to match
 * @param string $class Return class (eg. active)
 * 
 * @return string
 */
function checkPage($page, $class)
{
    if (strpos(getPageParams(), $page) !== false) {
        return $class;
    }
}

/**
 * RETURN THE CURRENT URL PARAMS
 *
 * @return string
 */
function getPageParams()
{
    $path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
    $params = str_replace($path, '', $_SERVER['REQUEST_URI']);

    return $params;
}
