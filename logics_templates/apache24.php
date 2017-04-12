<?php
$menu = [
    "icon" => "build",
    "color" => "red",
    "title" => "Apache error.log"
    "file" => "/var/log/apache2/error.log"
];
if (!is_readable($menu['file'])) {
    echo 'Unable to open the log file. Please check that the file is <a href="http://serverfault.com/questions/663837/make-error-log-readable-by-apache">readable by apache.</a>';
    die;
}

$content = file($menu['file']);

$log = [];
foreach ($content as $line) {
    // Grab the log's time and group logs by time
    $time = substr($line, 1, 19);
    if ($time != "") {
        // Remove date-time and other useless informations from the log details
        $line = substr($line, 34);
        $line = preg_replace("[\[:error.*\]]", "", $line);
        $line = preg_replace("[\[pid .*\]]", "", $line);
        $line = str_replace("PHP", "", $line);

        // Highlight the type of errors, using a badge
        $line = str_replace("Notice: ", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
        $line = str_replace("Warning: ", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
        $line = str_replace("Fatal error: ", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error:</span> ", $line);

        // Save the log entry
        $log[$time][] = trim($line);
    }
}

// Reverse the logs, so that we can see last errors first
$logs = array_reverse($log);
