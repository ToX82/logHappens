<?php

namespace Libs;

/**
 * Debug Helper
 *
 * Provides debugging utilities and functions.
 */
class DebugHelper
{
    /**
     * Debug function to print variables
     *
     * @param mixed $var Variable to be printed (string or array)
     * @return void
     */
    public static function debug($var): void
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    /**
     * Dump variable with more details
     *
     * @param mixed $var Variable to dump
     * @return void
     */
    public static function dump($var): void
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }

    /**
     * Log debug information to file
     *
     * @param mixed $data Data to log
     * @param string $level Log level (debug, info, warning, error)
     * @return void
     */
    public static function log($data, string $level = 'debug'): void
    {
        $logFile = ROOT . 'logs/debug.log';
        $timestamp = date('Y-m-d H:i:s');
        $message = "[{$timestamp}] [{$level}] " . print_r($data, true) . PHP_EOL;

        file_put_contents($logFile, $message, FILE_APPEND | LOCK_EX);
    }

    /**
     * Get memory usage information
     *
     * @return array Memory usage statistics
     */
    public static function getMemoryUsage(): array
    {
        return [
            'current' => memory_get_usage(),
            'peak' => memory_get_peak_usage(),
            'limit' => ini_get('memory_limit'),
        ];
    }

    /**
     * Get execution time information
     *
     * @return float Execution time in seconds
     */
    public static function getExecutionTime(): float
    {
        return microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
    }
}
