<?php

namespace Logics;

define('FILEPATH', ROOT . "config.json");

class Configurations
{
    public function getConfigurations()
    {
        if (file_exists(FILEPATH)) {
            $jsonString = file_get_contents(FILEPATH);
            $data = json_decode($jsonString);

            return $data->parsers;
        } else {
            return [];
        }
    }

    public function saveConfig()
    {
        $configurations = $this->getConfigurations();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-save-config'])) {
                $config = [];

                if (isset($_POST['input-name'])) {
                    $configName = $_POST['input-name'];
                } else {
                    $configName = preg_replace('/[^a-z0-9\s]/', '', strtolower($_POST["input-title"]));
                    $configName = $this->sanitizeTitle($configName);
                }

                $config['icon'] = $_POST["input-icon"];
                $config['color'] = $_POST["input-color"];
                $config['title'] = $this->sanitizeTitle($_POST["input-title"]);
                $config['file'] = $this->replaceSlash($_POST["input-file"]);
                $config['parser'] = $_POST["input-parser"];

                if (isset($_POST['input-disabled'])) {
                    $config['disabled'] = false;
                } else {
                    $config['disabled'] = true;
                }

                $configurations->$configName = $config;
                //debug($configurations);
                //die();

                $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                file_put_contents(ROOT . '/config.json', $jsonData);

                reload('configurations');
            }
        }
    }

    public function deleteConfig()
    {
        $configurations = $this->getConfigurations();
        $configName = $_GET['configName'];

        unset($configurations->$configName);

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        reload('configurations');
    }

    public function replaceSlash($filename)
    {
        // Read the contents of the file
        $content = file_get_contents($filename);

        // Replace all occurrences of '/' with '//'
        $content = str_replace('/', '//', $content);

        // Write the modified content back to the file
        file_put_contents($filename, $content);

        return $filename;
    }
    public function sanitizeTitle($title)
    {
        $title = trim($title);
        $title = str_replace(' ', '_', $title);

        return $title;
    }
    public function getAvailableParsers()
    {
        $files = scandir(ROOT . "/parsers/");

        $temp = array_slice($files, 2);
        $parsers = array_map(function ($element) {
            return str_replace(".php", "", $element);
        }, $temp);

        //print_r($parsers);
        return $parsers;
    }
    public function checkFileExists($filename)
    {
        if (file_exists($filename)) {
            return true;
        }
        return false;
    }
}
