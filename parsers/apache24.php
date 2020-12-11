<?php

$content = file($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    if (substr($line, 0, 1) != "[") {
        $logs[$time][] = str_replace("\n", "", $line);
    } else {
        // Grab the log's time and group logs by time
        $time = substr($line, 1, 19);
        $time = toDateTime($time);

        if ($time != '') {
            // Remove date-time and other useless informations from the log details
            $line = normalizeChars($line);
            $line = substr($line, 34);
            $line = preg_replace('[\[:error(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[pid (.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[php7(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[client(.*?)\]]', '', $line, 1);
            $line = str_replace('PHP', '', $line);
            $line = str_replace('\n', '<br>', $line);
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
    }
}
