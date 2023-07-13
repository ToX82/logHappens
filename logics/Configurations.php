<?php

namespace Logics;

define('FILENAME', "config.json");
define('FILEPATH', ROOT . FILENAME);

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
    public function modifyConfig($configurations, $configName) //perchè il nome viene passato in GET
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-modifyConfig'])) {

                $this->saveConfig($configurations, $configName);
            }
        }
    }
    public function addConfig($configurations)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-addConfig'])) {
                $configName = $_POST['input-name']; //string
                $$configName = new \stdClass(); //qui la variabile $var equivale al nome assegnato dall'utente
                $this->saveConfig($configurations, $configName);
            }
        }
    }

    public function saveConfig($configurations, $configName)
    {
        $config = new \stdClass();

        $config->icon = $_POST["input-icon"];
        $config->color = $_POST["input-color"];
        $config->title = $_POST["input-title"];
        $config->file = $this->replaceSlash($_POST["input-file"]);
        $config->parser = $_POST["input-parser"];

        if (isset($_POST['input-disabled'])) {
            $config->disabled = false;
        } else {
            $config->disabled = true;
        }

        $configurations->$configName = $config;
        //print_r($configurations);

        $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents(ROOT . '/config.json', $jsonData);

        reload('configurations');
    }

    public function deleteConfig($configurations, $configName)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-deleteConfig_' . $configName])) {
                echo "ok";
                unset($configurations->$configName);

                $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                file_put_contents(ROOT . '/config.json', $jsonData);

                reload('configurations');
            }
        }
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
}
