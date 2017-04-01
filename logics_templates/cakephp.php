<?php
$menu = [
    "icon" => "send",
    "color" => "teal",
    "title" => "Fatturazione error.log"
];
$content = file("/var/www/cakephp/logs/error.log");

$log = [];
foreach ($content as $line) {
    // Don't print the datetime for every record
    if (substr($line, 0, 3) == "201") {
        $time = substr($line, 0, 20);
        $line = str_replace($time, "", $line);
    }

    // Highlight the type of errors, using a badge
    $line = str_replace("Notice: ", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
    $line = str_replace("Warning: ", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
    $line = str_replace("Error: ", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

    $log[$time][] = trim($line);
}
$logs = array_reverse($log);
