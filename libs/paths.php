<?php

/**
 * Checks if a GET variable exists in the parameters
 *
 * @param string $name GET Variable's name
 * @return bool True if the variable exists, false otherwise
 */
function isPage($name)
{
    global $params;
    return in_array($name, $params);
}

/**
 * Splits the GET parameters into an array
 *
 * @return array Split parameters
 */
function splitQueryParams()
{
    $params = $_GET;
    if (empty($params) && isset($_SERVER['PATH_INFO'])) {
        $params = $_SERVER['PATH_INFO'];
        $params = [$params => ''];
    }
    list($params) = array_keys($params);
    $params = trim($params, "/");
    $params = explode("/", $params);

    if (count($params) === 1 && $params[0] === '') {
        $params = [];
    }

    return $params;
}

/**
 * Redirects to a specified destination or reloads the current page
 *
 * @param string $destination Destination URL
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
    die();
}

/**
 * Returns the current full URL
 *
 * @return string Current URL
 */
function currentUrl()
{
    return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

/**
 * Returns the base URL
 *
 * @return string Base URL
 */
function baseUrl()
{
    $url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = str_replace('/webroot/index.php', '', $url);

    return $url;
}

/**
 * Builds a complete URL with specified parameters
 *
 * @param string $params Desired URL parameters
 * @return string Complete URL
 */
function buildUrl($params)
{
    return BASE_URL . $params;
}

/**
 * Builds an asset URL with cache busting
 *
 * @param string $asset Desired asset URL
 * @return string Asset URL with file modification time as query string
 */
function buildAssetUrl($asset)
{
    $assetUrl = BASE_URL . $asset;
    $assetPath = ROOT . $asset;
    return $assetUrl . "?" . filemtime($assetPath);
}

/**
 * Checks if the passed page matches with the current URL and returns the specified class if it does
 *
 * @param string $page URL to match
 * @param string $class Return class (e.g., active)
 * @return string The class if the page matches, otherwise an empty string
 */
function checkPage($page, $class)
{
    if (strpos(getPageParams(), $page) !== false) {
        return $class;
    }

    return '';
}

/**
 * Returns the current URL parameters
 *
 * @return string Current URL parameters
 */
function getPageParams()
{
    $path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
    $params = str_replace($path, '', $_SERVER['REQUEST_URI']);

    return $params;
}
