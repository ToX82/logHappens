<?php
$menu = [
    "icon" => "send",
    "color" => "green",
    "title" => "A CakePHP 3.x error.log"
];
$content = file("/var/www/cakephp/logs/error.log");

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
