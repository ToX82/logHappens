<?php

namespace Logics;

class Configurations
{
    /**
     * Retrieves configurations from a JSON file.
     *
     * @param string $filePath The path to the JSON file.
     * @return array Returns an array of configurations.
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
            $config['file'] = $this->replaceSlash($_POST["input-file"]);
            $config['parser'] = $_POST["input-parser"];
            $config['disabled'] = isset($_POST['input-disabled']) ? false : true;

            $configurations->$configName = $config;

            $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            file_put_contents(ROOT . '/config.json', $jsonData);

            reload('configurations');
        }
    }

    /**
     * Deletes a configuration by name from the config file.
     *
     * @param string $configName The name of the configuration to delete.
     * @throws Some_Exception_Class Description of the exception that can be thrown.
     * @return void
     */
    public function deleteConfig($configName)
    {
        $configurations = $this->getConfigurations();

        unset($configurations->$configName);
        print_r($configName);

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        reload('configurations');
    }

    /**
     * Replaces all occurrences of '/' with '//' in the contents of a file.
     *
     * @param string $filename The path to the file.
     * @throws Exception If the file cannot be read or written.
     * @return string The path to the modified file.
     */
    public function replaceSlash($filename)
    {
        // Read the contents of the file
        $content = file_get_contents($filename);

        // Replace all occurrences of '/' with '//'
        $modifiedContent = str_replace('/', '//', $content);

        // Write the modified content back to the file
        file_put_contents($filename, $modifiedContent);

        return $filename;
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
        return file_exists($filename);
    }

    public function changeVisibility($configName)
    {
        $configurations = $this->getConfigurations();
        $configurations->$configName->disabled = !$configurations->$configName->disabled;

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);
    }
}
