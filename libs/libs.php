<?php

/**
 * Main library file
 */

namespace Libs;

use Libs\Container;
use Libs\Initializer;
use Libs\LanguageDetector;
use Libs\DebugHelper;
use Libs\ServiceProvider;

// Short class aliases for templates (shorthand helpers)
if (!class_exists('Url')) {
    class_alias(UrlHelper::class, 'Url');
}
if (!class_exists('Util')) {
    class_alias(Utilities::class, 'Util');
}

// Global container instance
$container = null;

/**
 * Get the global container instance
 *
 * @return Container
 */
function getContainer(): Container
{
    global $container;

    if ($container === null) {
        $container = new Container();
        $serviceProvider = new ServiceProvider($container);
        $serviceProvider->register();
    }

    return $container;
}

/**
 * Initialize the application
 *
 * @return void
 */
function init(): void
{
    $initializer = new Initializer();
    $initializer->initialize();
}

/**
 * Get language detector instance
 *
 * @return LanguageDetector
 */
function getLanguageDetector(): LanguageDetector
{
    static $detector = null;

    if ($detector === null) {
        $detector = new LanguageDetector();
    }

    return $detector;
}

/**
 * Get debug helper instance
 *
 * @return DebugHelper
 */
function getDebugHelper(): DebugHelper
{
    static $helper = null;

    if ($helper === null) {
        $helper = new DebugHelper();
    }

    return $helper;
}

// Backward compatibility functions
function getBrowserLanguage(): string
{
    return getLanguageDetector()->getBrowserLanguage();
}

function getFullBrowserLanguage(): string
{
    return getLanguageDetector()->getFullBrowserLanguage();
}

function getUserLanguage(): string
{
    return getLanguageDetector()->getUserLanguage();
}

function debug($var): void
{
    DebugHelper::debug($var);
}

function dump($var): void
{
    DebugHelper::dump($var);
}

function debugLog($data, string $level = 'debug'): void
{
    DebugHelper::log($data, $level);
}

function getMemoryUsage(): array
{
    return DebugHelper::getMemoryUsage();
}

function getExecutionTime(): float
{
    return DebugHelper::getExecutionTime();
}
