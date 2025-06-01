<?php

namespace Logics;

class Configurations
{
    /**
     * Retrieves configurations from a JSON file.
     *
     * @return object Returns an array of configurations.
     */
    public function getConfigurations()
    {
        if (file_exists(ROOT . "config.json")) {
            $jsonData = file_get_contents(ROOT . "config.json");
            $data = json_decode($jsonData);

            return $data->parsers;
        }

        return [];
    }

    /**
     * Saves the configuration data to the config.json file.
     *
     * @return void
     */
    public function saveConfig()
    {
        $configurations = $this->getConfigurations();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-save-config'])) {
            $config = [];
            $configName = isset($_POST['input-name']) ? $_POST['input-name'] : $this->slugString($_POST["input-title"]);

            $config['icon'] = $_POST["input-icon"];
            $config['color'] = $_POST["input-color"];
            $config['title'] = $_POST["input-title"];
            $config['file'] = $_POST["input-file"];
            $config['parser'] = $_POST["input-parser"];
            $config['disabled'] = isset($_POST['input-disabled']) ? false : true;

            $configurations->$configName = $config;

            $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            file_put_contents(ROOT . '/config.json', $jsonData);

            reload('configurations');
        }
    }

    /**
     * Duplicates a configuration file with a new name.
     *
     * @param string $configName The name of the configuration file to be duplicated.
     * @return void
     */
    public function duplicateConfig($configName)
    {
        $configurations = (array)$this->getConfigurations();
        $new = intval(array_key_last($configurations)) + 1;
        $configurations[$new] = clone $configurations[$configName];
        $configurations[$new]->title = $configurations[$new]->title . ' (Copy)';

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        reload('edit_configuration?configName=' . $new);
    }

    /**
     * Deletes a configuration by name from the config file.
     *
     * @param string $configName The name of the configuration to delete.
     * @return void
     */
    public function deleteConfig($configName)
    {
        $configurations = $this->getConfigurations();

        unset($configurations->$configName);

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        reload('configurations');
    }

    /**
     * Slugifies a string by removing special characters,
     * converting to lowercase, and replacing spaces with underscores.
     *
     * @param string $string The string to be slugified.
     * @return string The slugified string.
     */
    public function slugString($string)
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
    public function getAvailableParsers()
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
    public function checkFileExists($filename)
    {
        return file_exists($filename) && is_file($filename);
    }

    /**
     * Change the visibility of a configuration.
     *
     * @param string $configName The name of the configuration to change.
     * @return void
     */
    public function changeVisibility($configName)
    {
        $configurations = $this->getConfigurations();
        $configurations->$configName->disabled = !$configurations->$configName->disabled;

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);
    }

    /**
     * Generates the starter config file for the application.
     *
     * This function creates a new config file in the ROOT directory and
     * populates it with the default configurations. It also sets the
     * necessary permissions on the config file.
     */
    public function starterConfigFile()
    {
        if (is_writeable(ROOT)) {
            $starterFile = fopen(ROOT . "config.json", 'w');
            fclose($starterFile);

            $defaultConfigurations = file_get_contents(ROOT . "config.default.json");
            file_put_contents(ROOT . "config.json", $defaultConfigurations);
            chmod(ROOT . "config.json", 0777);
        }

        if (!is_file(ROOT . "config.json")) {
            reload('/display/create-config');
        } elseif (!is_writeable(ROOT . "config.json")) {
            reload('/display/create-config-writeable');
        }
    }

    /**
     * Updates the order of configurations based on the provided order array.
     *
     * @param array $order Array containing the configuration names in the new order
     * @return bool Returns true if successful, false otherwise
     */
    public function updateOrder($order)
    {
        $configurations = (array)$this->getConfigurations();
        $newConfigurations = [];

        foreach ($order as $configName) {
            if (isset($configurations[$configName])) {
                $newConfigurations[$configName] = $configurations[$configName];
            }
        }

        if (count($newConfigurations) === count($configurations)) {
            $jsonData = json_encode(['parsers' => (object)$newConfigurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return file_put_contents(ROOT . '/config.json', $jsonData) !== false;
        }

        return false;
    }
}
