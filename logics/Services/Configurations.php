<?php

declare(strict_types=1);

namespace Logics\Services;

use Libs\UrlHelper;

class Configurations
{
    /**
     * Retrieves configurations from a JSON file.
     *
     * @return array Returns an array of configurations.
     */
    public function getConfigurations(): array
    {
        if (file_exists(ROOT . "config.json")) {
            $jsonData = file_get_contents(ROOT . "config.json");
            $data = json_decode($jsonData, true);

            return $data['parsers'] ?? [];
        }

        return [];
    }

    /**
     * Saves the configuration data to the config.json file.
     *
     * @return void
     */
    public function saveConfig(): void
    {
        $configurations = $this->getConfigurations();

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['btn-save-config'])) {
            $config = [];

            $configKey = count($configurations) + 1;
            $rawName = $_POST['input-name'] ?? '';
            if ($rawName !== '' && is_numeric($rawName)) {
                $configKey = (int)$rawName;
            }

            $icon = (string)filter_var($_POST['input-icon'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $color = (string)filter_var($_POST['input-color'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $title = (string)filter_var($_POST['input-title'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $file = (string)filter_var($_POST['input-file'] ?? '', FILTER_UNSAFE_RAW);
            $parser = (string)filter_var($_POST['input-parser'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $disabled = !isset($_POST['input-disabled']);
            $truncatable = isset($_POST['input-truncatable']);

            $config['icon'] = $icon;
            $config['color'] = $color;
            $config['title'] = $title;
            $config['file'] = $file;
            $config['parser'] = $parser;
            $config['disabled'] = (bool)$disabled;
            $config['truncatable'] = (bool)$truncatable;

            $configurations[$configKey] = $config;

            $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            if ($jsonData !== false) {
                file_put_contents(ROOT . '/config.json', $jsonData);
            }

            UrlHelper::reload(UrlHelper::buildUrl('edit_configuration/' . $configKey));
        }
    }

    /**
     * Duplicates a configuration file with a new name.
     *
     * @param string $configName The name of the configuration file to be duplicated.
     * @return void
     */
    public function duplicateConfig(string $configName): void
    {
        $configurations = $this->getConfigurations();
        $new = count($configurations) + 1;
        $configurations[$new] = $configurations[$configName];
        $configurations[$new]['title'] = $configurations[$new]['title'] . ' (Copy)';

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        UrlHelper::reload(UrlHelper::buildUrl('edit_configuration/' . $new));
    }

    /**
     * Deletes a configuration by name from the config file.
     *
     * @param string $configName The name of the configuration to delete.
     * @return void
     */
    public function deleteConfig(string $configName): void
    {
        $configurations = $this->getConfigurations();

        unset($configurations[$configName]);

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        UrlHelper::reload(UrlHelper::buildUrl('configurations'));
    }

    /**
     * Slugifies a string by removing special characters,
     * converting to lowercase, and replacing spaces with underscores.
     *
     * @param string $string The string to be slugified.
     * @return string The slugified string.
     */
    public function slugString(string $string): string
    {
        $slug = preg_replace('/[^a-z0-9\s]/', '', strtolower($string));
        $slug = trim($slug);
        $slug = str_replace(' ', '_', $slug);

        return $slug;
    }

    /**
     * Retrieves the list of available parsers.
     *
     * This function scans the "/parsers/" directory and retrieves the list
     * of available parsers by removing the file extension from each file name.
     *
     * @return array The list of available parsers.
     */
    public function getAvailableParsers(): array
    {
        $directory = ROOT . "/parsers/";

        $files = scandir($directory);

        $filteredFiles = array_slice($files, 2);

        $parsers = array_map(function ($file) {
            return str_replace(".php", "", $file);
        }, $filteredFiles);

        return $parsers;
    }

    /**
     * Checks if a file exists.
     *
     * @param string $filename The name of the file to check.
     * @return bool Returns true if the file exists, false otherwise.
     */
    public function checkFileExists(string $filename): bool
    {
        return file_exists($filename) && is_file($filename);
    }

    /**
     * Change the visibility of a configuration.
     *
     * @param string $configName The name of the configuration to change.
     * @return array Returns the configuration array.
     */
    public function changeVisibility(string $configName): array
    {
        $configurations = $this->getConfigurations();
        $configurations[$configName]['disabled'] = !$configurations[$configName]['disabled'];

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        return $configurations[$configName];
    }

    /**
     * Generates the starter config file for the application.
     *
     * This function creates a new config file in the ROOT directory and
     * populates it with the default configurations. It also sets the
     * necessary permissions on the config file.
     */
    public function starterConfigFile(): void
    {
        if (is_writeable(ROOT)) {
            $starterFile = fopen(ROOT . "config.json", 'w');
            fclose($starterFile);

            $defaultConfigurations = file_get_contents(ROOT . "config.default.json");
            file_put_contents(ROOT . "config.json", $defaultConfigurations);
            chmod(ROOT . "config.json", 0664);
        }

        if (!is_file(ROOT . "config.json")) {
            UrlHelper::reload(UrlHelper::buildUrl('/display/create-config'));
        } elseif (!is_writeable(ROOT . "config.json")) {
            UrlHelper::reload(UrlHelper::buildUrl('/display/create-config-writeable'));
        }
    }

    /**
     * Updates the order of configurations based on the provided order array.
     *
     * @param array $order Array containing the configuration names in the new order
     * @return bool Returns true if successful, false otherwise
     */
    public function updateOrder(array $order): bool
    {
        $configurations = $this->getConfigurations();
        $newConfigurations = [];

        foreach ($order as $configName) {
            if (isset($configurations[$configName])) {
                $newConfigurations[$configName] = $configurations[$configName];
            }
        }

        if (count($newConfigurations) === count($configurations)) {
            $jsonData = json_encode(['parsers' => $newConfigurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return file_put_contents(ROOT . '/config.json', $jsonData) !== false;
        }

        return false;
    }
}
