<?php
$menu = [
    "icon" => "build",
    "color" => "red",
    "title" => "Apache error.log"
];
$content = file("/var/log/apache2/error.log");

$group = "";
$log = [];
foreach ($content as $line) {
    // Grab the log's time and group logs by time
    $time = substr($line, 1, 19);
    if ($time != "") {
        // Remove date-time and other useless informations from the log details
        $line = substr($line, 34);
        if (substr($line, 0, 13) == "[:error] [pid") {
            $line = substr($line, 45);
        }
        $line = str_replace("PHP", "", $line);
        $line = trim($line);

        // Add vertical spacing for warnings and notices
        if (substr($line, 0, 9) == "Warning: ") {
            $line = "<br>" . $line;
        }
        if (substr($line, 0, 8) == "Notice: ") {
            $line = "<br>" . $line;
        }

        // Save the log entry
        $log[$time][] = $line;
    }
}

// Reverse the logs, so that we can see last errors first
$logs = array_reverse($log);
