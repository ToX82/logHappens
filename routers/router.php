<?php

use Logics\Services\Parsers;
use Logics\Services\Configurations;
use Logics\Controllers\LogsController;
use Logics\Controllers\PagesController;
use Logics\Controllers\SettingsController;
use Logics\Controllers\ConfigurationsController;

// Use namespaced helpers explicitly
$params = \Libs\UrlHelper::splitQueryParams();

// Get container instance
$container = \Libs\getContainer();

try {
    // Resolve services from container
    $parsers = $container->resolve('parsers');
    // Keep backward compatibility for views
    $objParsers = $parsers;
} catch (Exception $e) {
    echo file_get_contents(ROOT . 'webroot/composer_update.html');
    die;
}

// Resolve controllers from container
$logsController = $container->resolve('logs.controller');
$configsController = $container->resolve('configurations.controller');
$pagesController = $container->resolve('pages.controller');
$settingsController = $container->resolve('settings.controller');

$views = [];
$pageTitle = $pageTitle ?? '';
$countAll = $countAll ?? null;
$configurations = $configurations ?? null;
$config = $config ?? null;

$logsController->countAll($countAll);

if (empty($params)) {
    $logsController->handleDefault($countAll);
}

$action = $params[0] ?? '';
switch ($action) {
    case 'truncate':
        $file = \Libs\Security::filterString(1);
        $logsController->truncate($file);
        break;
    case 'viewlog':
        $file = \Libs\Security::filterString(1);
        $logs = $logsController->view($pageTitle, $views, $file);
        break;
    case 'display':
        $displayPage = \Libs\Security::filterString(1);
        $pagesController->display($pageTitle, $views, $displayPage, $countAll);
        break;
    case 'configurations':
        $configsController->index($pageTitle, $views, $configurations);
        break;
    case 'edit_configuration':
        $configName = \Libs\Security::filterString(1);
        $configsController->edit($pageTitle, $views, $parsers, $config, $configName);
        break;
    case 'add_configuration':
        $configsController->add($pageTitle, $views, $parsers);
        break;
    case 'save_configurations':
        $configsController->save();
        break;
    case 'duplicate_configuration':
        $configName = \Libs\Security::filterString(1);
        $configsController->duplicate($configName);
        break;
    case 'delete_configuration':
        $configName = \Libs\Security::filterString(1);
        $configsController->delete($configName);
        break;
    case 'writesettings':
        $parameter = \Libs\Security::filterString(1);
        $selected = \Libs\Security::filterString(2);
        $settingsController->write($parameter, $selected);
        break;
    default:
        $pageTitle = "Wooooops";
        $views[] = ROOT . "views/pages/404.php";
        break;
}
