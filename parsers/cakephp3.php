<?php

$content = file($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    // Don't print the datetime for every record
    if (substr($line, 0, 3) == "202") {
        $time = substr($line, 0, 20);
        $line = str_replace($time, "", $line);
        $time = date("l d-m-Y - H:i:s", strtotime($time));
    }
    $line = normalizeChars($line);
    $line = trim($line);

    // Highlight the type of errors, using a badge
    $line = preg_replace("/^Debug_log: /", "<span class='lh-badge' style='background-color: #1e88e5;'>Debug_log:</span> ", $line);
    $line = preg_replace("/^Notice: /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
    $line = preg_replace("/^Warning: /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
    $line = preg_replace("/^Fatal error: /", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error:</span> ", $line);
    $line = preg_replace("/^Parse error: /", "<span class='lh-badge' style='background-color: #a71616;'>Parse error:</span> ", $line);
    $line = preg_replace("/^Error: /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

    // Save the log entry
    $logs[$time][] = $line;
}
