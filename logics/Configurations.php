<?php

function getConfigurations($filepath) {
    $jsonString = file_get_contents($filepath);
    $data = json_decode($jsonString);

    return $data->parsers;
}


function modifyAndSaveConfig($configurations, $configName, $config, $modify) {
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //check if the 'modify' button is clicked
        if(isset($_POST['btn-modify_'.$configName])) {
            $modify = true;
        }
        else {
            $modify = false;
        }
        //check if the 'save' button is clicked
        
        if(isset($_POST['btn-save_'.$configName])) {
            $temp = new stdClass();
            echo $_POST["input-icon"];
            $temp->icon = $_POST["input-icon"];
            $temp->color = $_POST["input-color"];
            $temp->title = $_POST["input-title"];
            $temp->file = $_POST["input-file"];
            $temp->parser = $_POST["input-parser"];
            if(isset($_POST['input-disabled'])) $temp->disabled = false;
            else $temp->disabled = true;

            $configurations->$configName = $temp;

            //print_r($configurations);
            
            $jsonData = json_encode(['parsers' => $configurations], JSON_PRETTY_PRINT);
            file_put_contents(ROOT . '/config.json', $jsonData);
        }
    }
    return $modify;
}

function addConfig($configurations) {
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