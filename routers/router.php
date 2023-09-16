<?php

$params = splitQueryParams();
$objParsers = new logics\Parsers(ROOT . "config.json");

// Array con le pagine di template da includere
$views = [];

// Actions to be done for every request
$countAll = $objParsers->countall();

// If there are no params in the URL, proceed
if (empty($params)) {
    if (empty($countAll)) {
        reload('display/start');
    }
    reload('display/info');
}

// Page specific actions
if (isPage('truncate')) {
    $pageTitle = "";

    $file = filterString(1);
    $logs = $objParsers->truncate($file);
    reload("/viewlog/" . $file);
}

if (isPage('viewlog')) {
    $file = filterString(1);
    $logs = $objParsers->view($file);
    $pageTitle = $logs['title'];
    $views[] = ROOT . "views/parsers/log_reader.php";
}

if (isPage('display')) {
    $displayPage = filterString(1);
    $pageTitle = ucfirst($displayPage);

    if ($displayPage === 'start') {
        if (!empty($countAll)) {
            reload('/display/info');
        }
    }

    $file = logics\Pages::display($displayPage);
    $views[] = ROOT . $file;
}

if (isPage('configurations')) {
    $configClass = new Logics\Configurations();

    if (!file_exists(ROOT . "config.json") || !is_writeable(ROOT . "config.json")) {
        $configClass->starterConfigFile();
        reload('/configurations');
    }

    $pageTitle = "Configurations";

    $configurations = $configClass->getConfigurations();

    $views[] = ROOT . "views/pages/configurations/configurations.php";
}

if (isPage('edit_configuration')) {
    $pageTitle = "Edit Configuration";

    $configClass = new Logics\Configurations();
    $configName = $_GET['configName'];
    $parsers = $configClass->getAvailableParsers();

    $configurations = $configClass->getConfigurations();
    $config = $configurations->$configName;

    $views[] = ROOT . "views/pages/configurations/edit_configuration.php";
}

if (isPage('add_configuration')) {
    $pageTitle = "Add Configuration";

    $configClass = new Logics\Configurations();
    $parsers = $configClass->getAvailableParsers();

    $views[] = ROOT . "views/pages/configurations/add_configuration.php";
}

if (isPage('save_configurations')) {
    $configClass = new Logics\Configurations();

    $configClass->saveConfig();
}

if (isPage('duplicate_configuration')) {
    $configClass = new Logics\Configurations();
    $configName = $_GET['configName'];

    $configClass->duplicateConfig($configName);
}

if (isPage('delete_configuration')) {
    $configClass = new Logics\Configurations();
    $configName = $_GET['configName'];

    $configClass->deleteConfig($configName);
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
    $pageTitle = "Wooooops";
    $views[] = ROOT . "views/pages/404.php";
}
