<?php

$params = splitQueryParams();
$objParsers = new logics\Parsers(ROOT . "config.json");

// Array con le pagine di template da includere
$views = [];

// Actions to be done for every request
$countAll = $objParsers->countall();

// Se non esiste un parametro nella URL seleziono la home page
if (empty($params)) {
    if (empty($countAll)) {
        reload('display/start');
    }
    reload('display/info');
}

// Page specific actions
if (isPage('truncate')) {
    $pageTitle = "Parsers";

    $file = filterString(1);
    $logs = $objParsers->truncate($file);
    reload("/viewlog/" . $file);
}

if (isPage('viewlog')) {
    $pageTitle = "Parsers";

    $file = filterString(1);
    $logs = $objParsers->view($file);
    $views[] = ROOT . "views/parsers/log_reader.php";
}

if (isPage('display')) {
    $pageTitle = "Display";

    $displayPage = filterString(1);
    $file = logics\Pages::display($displayPage);
    $views[] = ROOT . $file;
}

if (isPage('writesettings')) {
    $parameter = filterString(1);
    $selected = filterString(2);
    writeSettingsCookie($parameter, $selected);

    if (isset($_SERVER['HTTP_REFERER'])) {
        reload($_SERVER['HTTP_REFERER']);
    }

    reload('/');
}

if (empty($views)) {
    $views[] = ROOT . "views/pages/404.php";
}
