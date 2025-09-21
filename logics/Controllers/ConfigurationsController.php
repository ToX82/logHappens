<?php

declare(strict_types=1);

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

    public function index(&$pageTitle, &$views, &$configurations): void
    {
        if (!file_exists(ROOT . "config.json") || !is_writeable(ROOT . "config.json")) {
            $this->configService->starterConfigFile();
            UrlHelper::reload(UrlHelper::buildUrl('/configurations'));
        }

        $pageTitle = "Configurations";
        $configurations = $this->configService->getConfigurations();
        $views[] = ROOT . "views/configurations/index.php";
    }

    public function edit(&$pageTitle, &$views, &$parsers, &$config, &$configName): void
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

    public function add(&$pageTitle, &$views, &$parsers): void
    {
        $pageTitle = 'Add Configuration';
        $parsers = $this->configService->getAvailableParsers();
        $views[] = ROOT . 'views/configurations/add.php';
    }

    public function save(): void
    {
        $this->configService->saveConfig();
    }

    public function duplicate(string $configName): void
    {
        $this->configService->duplicateConfig($configName);
    }

    public function delete(string $configName): void
    {
        $this->configService->deleteConfig($configName);
    }
}
