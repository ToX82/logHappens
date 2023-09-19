<?php

$content = openFileOrDie($data['file']);

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
            $line = preg_replace('[\[php:(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[client(.*?)\]]', '', $line, 1);
            $line = str_replace('PHP', '', $line);
            $line = htmlentities($line);
            $line = str_replace('\n', '<br>', $line);

            // remove trailing spaces at the end of the line
            $line = preg_replace('/\s+$/m', '', $line);

            // Highlight the type of errors, using a badge
            $line = preg_replace("/^(\s*)Debug_log: /", "<span class='lh-badge' style='background-color: #1e88e5;'>Debug_log:</span> ", $line);
            $line = preg_replace("/^(\s*)Notice: /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
            $line = preg_replace("/^(\s*)Warning: /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
            $line = preg_replace("/^(\s*)Fatal error: /", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error:</span> ", $line);
            $line = preg_replace("/^(\s*)Parse error: /", "<span class='lh-badge' style='background-color: #a71616;'>Parse error:</span> ", $line);
            $line = preg_replace("/^(\s*)Error: /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

            // Save the log entry
            $logs[$time][] = $line;
        }
    }
}
