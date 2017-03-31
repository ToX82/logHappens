<?php
$menu = [
    "icon" => "palette",
    "color" => "orange",
    "title" => "Il Papiro Web error.log"
];
$content = file("/var/www/papiro_nuovo/logs/php-error.log");

$group = "";
$log = [];
foreach ($content as $line) {
    $time = substr($line, 1, 20);
    if ($time != "") {
        $line = substr($line, 36); // Cancello l'ora dalla riga

        $line = str_replace("PHP", "", $line);
        $line = trim($line);

        if (substr($line, 0, 9) == "Warning: ") {
            $line = "<br>" . $line;
        }
        if (substr($line, 0, 8) == "Notice: ") {
            $line = "<br>" . $line;
        }

        $log[$time][] = $line;
    }
}
$logs = array_reverse($log);
