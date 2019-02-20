<?php
$menu = [
    "icon" => "logos:cakephp",
    "color" => "red",
    "title" => "CakePHP 2.x - 3.x error.log",
    "file" => "/var/www/cakephp/logs/error.log"
];
if (!is_readable($menu['file'])) {
    echo 'Unable to open the log file. Please check that the file is <a href="http://serverfault.com/questions/663837/make-error-log-readable-by-apache">readable by apache.</a>';
    die;
}

$content = file($menu['file']);

$log = [];
foreach ($content as $line) {
    // Don't print the datetime for every record
    if (substr($line, 0, 3) == "201") {
        $time = substr($line, 0, 20);
        $line = str_replace($time, "", $line);
        $time = date("l d-m-Y - H:i:s", strtotime($time));
    }
    $line = trim($line);

    // Highlight the type of errors, using a badge
    $line = preg_replace("/^Notice: /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
    $line = preg_replace("/^Warning: /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
    $line = preg_replace("/^Fatal error: /", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error:</span> ", $line);
    $line = preg_replace("/^Parse error: /", "<span class='lh-badge' style='background-color: #a71616;'>Parse error:</span> ", $line);
    $line = preg_replace("/^Error: /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

    // Save the log entry
    $log[$time][] = $line;
}

// Reverse the logs, so that we can see last errors first
$logs = array_reverse($log);
