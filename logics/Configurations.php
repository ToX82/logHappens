<?php

namespace Logics;

define('FILENAME', "config.json");
define('FILEPATH', ROOT . FILENAME);

class Configurations
{
    public function openEditPage($configName)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['btn-edit'])) {
                header(buildUrl("edit_configuration.php"));
            }
        }
    }

    public function getConfigurations() {
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
                $temp->file = $_POST["input-file"];
                $temp->parser = $_POST["input-parser"];

                if (isset($_POST['input-disabled'])) {
                    $temp->disabled = false;
                } else {
                    $temp->disabled = true;
                }

                $configurations->$configName = $temp;

                //print_r($configurations);

                $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT);
                file_put_contents(FILEPATH, $jsonData);

                reload('configurations');
            }
        }
    }

    public function addConfig($configurations) {
        if(isset($_POST['btn-close'])) {
            $config = new stdClass();
            $config->icon = $_POST['txt-icon'];
            $config->color = $_POST['txt-color'];
            $config->title = $_POST['txt-title'];
            $config->file = $_POST['txt-file'];
            $config->parser = $_POST['txt-parser'];
            if(isset($_POST['txt-disabled'])) $config->disabled = false;
            else $config->disabled = true;

            $var = $_POST['txt-name']; //string
            $$var = new stdClass(); //qui la variabile $var equivale al nome assegnato dall'utente
            $configurations->$var = $config;
            //print_r($configurations);

            $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT);
            file_put_contents(ROOT . '/config.json', $jsonData);


            }
    }
}
