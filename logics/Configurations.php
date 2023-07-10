<?php

function getConfigurations($filepath) {
    $jsonString = file_get_contents($filepath);
    $data = json_decode($jsonString);

    return $data->parsers;
}

function displayConfigurations($configurations) {
    
    $modify = false;

    echo '<div class="card-body d-flex flex-column">';
    foreach ($configurations as $configName => $value) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['btn-modify_'.$configName])) {
                $modify = true;
            }
            else {
                $modify = false;
            }
                
        }

        echo 
        '<form method="post" class="card mb-3">'.
            '<div class="card-header d-flex justify-content-between align-items-center">
                <label for="configName">'.$configName.'</label>';
                echo $modify ? '<input type="submit" value="Save" name="btn-save_'.$configName.'" class="btn btn-success btn-sm">'
                : '<input type="submit" value="Modify" name="btn-modify_'.$configName.'" class="btn btn-primary btn-sm">';
            echo '</div>';
        displayOptions($configurations, $configName, $value, $modify);
        echo '</form>';
    }
    echo '</div>';
}
function displayOptions($configurations, $configName, $config, $modify) {
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['btn-save_'.$configName])) {
            $temp = new stdClass();
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
    
    
    echo '<div class="mt-3 d-flex flex-column">'.
            '<div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">'.
                '<h6><label for="icon" class="form-label">Icon</label></h6>
                <input class="" type="text" id="input-icon" name="input-icon" ';
                echo $modify ? '' : ' hidden ';
                echo ' value="'.$config->icon.'"/>';
                if(!$modify) echo $config->icon;
                    
                    
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="color" class="form-label">Color</label></h6>
                    <input '; echo $modify ? '' : 'hidden'; echo ' type="color" class="form-control form-control-color" id="input-color" name="input-color" value="'.$config->color.'">
                    <input '; echo $modify ? 'hidden' : ''; echo ' disabled readonly type="color" class="form-control form-control-color" id="display-color" name="display-color" value="'.$config->color.'">

                    </div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="title" class="form-label">Title</label></h6>
                    <input type="text" class="form-control" id="input-title" name="input-title" ';
                    echo $modify ? '' : ' hidden ';
                    echo ' value="'.$config->title.'"/>';
                    if(!$modify) echo $config->title;
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="file" class="form-label">File</label></h6>
                    <input type="text" class="form-control" id="input-file" name="input-file" ';
                    echo $modify ? '' : ' hidden ';
                    echo ' value="'.$config->file.'"/>';
                    if(!$modify) echo $config->file;
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="parser" class="form-label">Parser</label></h6>
                    <input type="text" class="form-control" id="input-parser" name="input-parser" ';
                    echo $modify ? '' : ' hidden ';
                    echo ' value="'.$config->parser.'"/>';
                    if(!$modify) echo $config->parser;
                echo '</div>'.


                //TODO il pulsante è cliccabile nel display ma non viene modificato il suo stato
            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="state" class="form-label">State</label></h6>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled" role="switch"';
                    if(!$config->disabled) {
                        echo 'checked';
                    }
                    echo '>
                </div>
            </div>'.
            '</div>';
}