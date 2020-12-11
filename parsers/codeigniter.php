<?php

$content = file($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    // Don't print the datetime for every record
    $dateStartChr = strpos($line, " - ") + 3;
    if (substr($line, $dateStartChr, 3) == "202") {
        $time = substr($line, $dateStartChr, 20);
        $line = str_replace($time, "", $line);
        $time = date("l d-m-Y - H:i:s", strtotime($time));
    } else {
        continue;
    }

    $line = str_replace(' -->', '', $line);
    $line = normalizeChars($line);
    $line = trim($line);

    // Highlight the type of errors, using a badge
    $line = preg_replace("/^NOTICE - /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
    $line = preg_replace("/^WARNING - /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
    $line = preg_replace("/^INFO - /", "<span class='lh-badge' style='background-color: #a79716;'>Info:</span> ", $line);
    $line = preg_replace("/^ERROR - /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

    $line = str_replace("Severity: Warning", "<span class='lh-badge' style='background-color: #a79716;'>Warning</span> ", $line);

    // Save the log entry
    $logs[$time][] = $line;
}
