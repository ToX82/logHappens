<?php

use Logics\Services\Parsers;
use Logics\Services\Configurations;
use Logics\Controllers\LogsController;
use Logics\Controllers\PagesController;
use Logics\Controllers\SettingsController;
use Logics\Controllers\ConfigurationsController;

$params = splitQueryParams();
try {
    $parsers = new Parsers();
    // Keep backward compatibility for views
    $objParsers = $parsers;
} catch (Exception $e) {
    echo file_get_contents(ROOT . 'webroot/composer_update.html');
    die;
}

$configurationsService = new Configurations();
$logsController = new LogsController($parsers);
$configsController = new ConfigurationsController($configurationsService);
$pagesController = new PagesController();
$settingsController = new SettingsController();

$views = [];

$logsController->countAll($countAll);

if (empty($params)) {
    $logsController->handleDefault($countAll);
}

$action = $params[0] ?? '';
switch ($action) {
    case 'truncate':
        $file = filterString(1);
        $logsController->truncate($file);
        break;
    case 'viewlog':
        $file = filterString(1);
        $logs = $logsController->view($pageTitle, $views, $file);
        break;
    case 'display':
        $displayPage = filterString(1);
        $pagesController->display($pageTitle, $views, $displayPage, $countAll);
        break;
    case 'configurations':
        $configsController->index($pageTitle, $views, $configurations);
        break;
    case 'edit_configuration':
        $configName = filterString(1);
        $configsController->edit($pageTitle, $views, $parsers, $config, $configName);
        break;
    case 'add_configuration':
        $configsController->add($pageTitle, $views, $parsers);
        break;
    case 'save_configurations':
        $configsController->save();
        break;
    case 'duplicate_configuration':
        $configName = filterString(1);
        $configsController->duplicate($configName);
        break;
    case 'delete_configuration':
        $configName = filterString(1);
        $configsController->delete($configName);
        break;
    case 'writesettings':
        $parameter = filterString(1);
        $selected = filterString(2);
        $settingsController->write($parameter, $selected);
        break;
    default:
        $pageTitle = "Wooooops";
        $views[] = ROOT . "views/pages/404.php";
        break;
}
