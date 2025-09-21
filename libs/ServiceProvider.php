<?php

namespace Libs;

use Libs\Container;
use Logics\Services\Parsers;
use Logics\Services\Configurations;
use Logics\Services\Pages;
use Logics\Controllers\LogsController;
use Logics\Controllers\ConfigurationsController;
use Logics\Controllers\PagesController;
use Logics\Controllers\SettingsController;

/**
 * Service Provider for registering application services
 *
 * Centralizes the registration of all application services with the container.
 */
class ServiceProvider
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * Constructor
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register all application services
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerServices();
        $this->registerControllers();
    }

    /**
     * Register core services
     *
     * @return void
     */
    private function registerServices(): void
    {
        // Register Parsers service
        $this->container->singleton('parsers', function (Container $container) {
            return new Parsers();
        });

        // Register Configurations service
        $this->container->singleton('configurations', function (Container $container) {
            return new Configurations();
        });

        // Register Pages service
        $this->container->singleton('pages', function (Container $container) {
            return new Pages();
        });
    }

    /**
     * Register controllers with their dependencies
     *
     * @return void
     */
    private function registerControllers(): void
    {
        // Register LogsController
        $this->container->register('logs.controller', function (Container $container) {
            $parsers = $container->resolve('parsers');
            return new LogsController($parsers);
        });

        // Register ConfigurationsController
        $this->container->register('configurations.controller', function (Container $container) {
            $configurations = $container->resolve('configurations');
            return new ConfigurationsController($configurations);
        });

        // Register PagesController
        $this->container->register('pages.controller', function (Container $container) {
            return new PagesController();
        });

        // Register SettingsController
        $this->container->register('settings.controller', function (Container $container) {
            return new SettingsController();
        });
    }
}
