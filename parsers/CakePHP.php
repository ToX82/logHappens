<?php

$content = openFileOrDie($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    // Don't print the datetime for every record
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $line, $matches)) {
        $time = substr($line, 0, 20);
        $line = str_replace($time, "", $line);
        $time = toDateTime($time);
    }
    $line = normalizeChars($line);

    // remove trailing spaces at the end of the line
    $line = preg_replace('/\s+$/m', '', $line);
    $line = htmlentities($line);

    // Highlight the type of errors, using a badge
    $line = preg_replace("/^(\s*)Debug_log: /i", "<span class='lh-badge' style='background-color: #1e88e5;'>Debug_log</span> ", $line);
    $line = preg_replace("/^(\s*)Notice: /i", "<span class='lh-badge' style='background-color: #318418;'>Notice</span> ", $line);
    $line = preg_replace("/^(\s*)Warning: /i", "<span class='lh-badge' style='background-color: #a79716;'>Warning</span> ", $line);
    $line = preg_replace("/^(\s*)Fatal error: /i", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error</span> ", $line);
    $line = preg_replace("/^(\s*)Parse error: /i", "<span class='lh-badge' style='background-color: #a71616;'>Parse error</span> ", $line);
    $line = preg_replace("/^(\s*)Error: /i", "<span class='lh-badge' style='background-color: #a71616;'>Error</span> ", $line);

    // Save the log entry
    $logs[$time][] = $line;
}
