<?php
$content = file("/var/www/fatturazione/logs/error.log");

$group = "";
$log = [];
foreach ($content as $line) {
    if (substr($line, 0, 3) == "201") {
        $time = substr($line, 0, 20);
    }
    $line = trim($line);
    $log[$time][] = $line;
}
$logs = array_reverse($log);
