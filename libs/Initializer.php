<?php

namespace Libs;

use Libs\UrlHelper;
use Libs\Utilities;

/**
 * Application Initializer
 *
 * Handles application initialization, configuration loading, and basic setup.
 */
class Initializer
{
    /**
     * Initialize the application
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->checkDependencies();
        $this->loadAutoloader();
        $this->setHeaders();
        $this->configureErrorReporting();
        $this->loadSettings();
        $this->defineConstants();
    }

    /**
     * Set HTTP headers
     *
     * @return void
     */
    private function setHeaders(): void
    {
        header('Content-type: text/html;charset=utf-8');
    }

    /**
     * Configure error reporting
     *
     * @return void
     */
    private function configureErrorReporting(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL ^ E_DEPRECATED);
    }

    /**
     * Load application settings
     *
     * @return void
     */
    private function loadSettings(): void
    {
        Utilities::setting('theme');
        Utilities::setting('refresh');
        Utilities::setting('page-length');
    }

    /**
     * Define application constants
     *
     * @return void
     */
    private function defineConstants(): void
    {
        if (!defined('BASE_URL')) {
            define('BASE_URL', rtrim(UrlHelper::baseUrl(), '/') . "/");
        }
    }

    /**
     * Check if required dependencies are available
     *
     * @return void
     * @throws \RuntimeException If autoloader is missing
     */
    private function checkDependencies(): void
    {
        if (!is_file(ROOT . 'vendor/autoload.php')) {
            echo file_get_contents(ROOT . 'webroot/firstrun.html');
            throw new \RuntimeException('Composer autoloader not found');
        }
    }

    /**
     * Load Composer autoloader
     *
     * @return void
     */
    private function loadAutoloader(): void
    {
        require_once ROOT . 'vendor/autoload.php';
    }
}
