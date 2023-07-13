<?php

namespace Logics;

define('FILENAME', "config.json");
define('FILEPATH', ROOT . FILENAME);

class Configurations
{
    public function addConfig($configurations)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-addConfig'])) {
                $config = new \stdClass();

                $config->icon = $_POST["txt-add-icon"];
                $config->color = $_POST["txt-add-color"];
                $config->title = $_POST["txt-add-title"];
                $config->file = $this->replaceSlash($_POST["txt-add-file"]);
                $config->parser = $_POST["txt-add-parser"];

                if (isset($_POST['txt-add-disabled'])) {
                    $config->disabled = false;
                } else {
                    $config->disabled = true;
                }

                $var = $_POST['txt-add-name']; //string
                $$var = new \stdClass(); //qui la variabile $var equivale al nome assegnato dall'utente
                $configurations->$var = $config;
                //print_r($configurations);

                $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                file_put_contents(ROOT . '/config.json', $jsonData);

                reload('configurations');
            }
        }

    }

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


    public function saveConfig($configurations, $configName)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-modifyConfig'])) {
                $temp = new \stdClass();

                $temp->icon = $_POST["input-icon"];
                $temp->color = $_POST["input-color"];
                $temp->title = $_POST["input-title"];
                $temp->file = $this->replaceSlash($_POST["input-file"]);
                $temp->parser = $_POST["input-parser"];

                if (isset($_POST['input-disabled'])) {
                    $temp->disabled = false;
                } else {
                    $temp->disabled = true;
                }

                $configurations->$configName = $temp;

                //print_r($configurations);

                $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                file_put_contents(FILEPATH, $jsonData);

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
