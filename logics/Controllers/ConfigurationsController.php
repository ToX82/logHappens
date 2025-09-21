<?php

namespace Logics\Controllers;

use Libs\UrlHelper;
use Logics\Services\Configurations;

class ConfigurationsController
{
    private $configService;

    public function __construct(Configurations $configService)
    {
        $this->configService = $configService;
    }

    public function index(&$pageTitle, &$views, &$configurations)
    {
        if (!file_exists(ROOT . "config.json") || !is_writeable(ROOT . "config.json")) {
            $this->configService->starterConfigFile();
            UrlHelper::reload(UrlHelper::buildUrl('/configurations'));
        }

        $pageTitle = "Configurations";
        $configurations = $this->configService->getConfigurations();
        $views[] = ROOT . "views/configurations/index.php";
    }

    public function edit(&$pageTitle, &$views, &$parsers, &$config, &$configName)
    {
        $pageTitle = 'Edit Configuration';
        $parsers = $this->configService->getAvailableParsers();
        $configurations = $this->configService->getConfigurations();
        $config = $configurations[$configName] ?? null;

        // Check if configuration exists
        if ($config === null) {
            $pageTitle = "Configuration Not Found";
            $views[] = ROOT . 'views/pages/404.php';
            return;
        }

        $views[] = ROOT . 'views/configurations/edit.php';
    }

    public function add(&$pageTitle, &$views, &$parsers)
    {
        $pageTitle = 'Add Configuration';
        $parsers = $this->configService->getAvailableParsers();
        $views[] = ROOT . 'views/configurations/add.php';
    }

    public function save()
    {
        $this->configService->saveConfig();
    }

    public function duplicate($configName)
    {
        $this->configService->duplicateConfig($configName);
    }

    public function delete($configName)
    {
        $this->configService->deleteConfig($configName);
    }
}
