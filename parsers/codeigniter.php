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
    $lineStart = strpos($line, " --> Severity: ") + 15;
    $line = substr($line, $lineStart, 999999);
    $line = trim($line);

    // Highlight the type of errors, using a badge
    $line = preg_replace("/^Notice --> /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
    $line = preg_replace("/^Warning --> /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
    $line = preg_replace("/^Error --> /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

    // Save the log entry
    $logs[$time][] = $line;
}
