<?php

$content = file($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    if (substr($line, 0, 1) != "[") {
        $logs[$time][] = str_replace("\n", "", $line);
    } else {
        // Grab the log's time and group logs by time
        $time = substr($line, 1, 20);
        $time = toDateTime($time);

        if ($time != '') {
            // Remove date-time and other useless informations from the log details
            $timeEnd = strpos($line, "] ");
            $line = substr($line, $timeEnd + 2);
            $line = preg_replace('[\[:error(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[pid (.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[php7(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[client(.*?)\]]', '', $line, 1);
            $line = str_replace('PHP', '', $line);
            $line = str_replace('\n', '<br>', $line);
            $line = normalizeChars($line);
            $line = trim($line);

            // Highlight the type of errors, using a badge
            $line = preg_replace("/^OTHER/", "<span class='lh-badge' style='background-color: #1e88e5;'>Other:</span> ", $line);
            $line = preg_replace("/^E_NOTICE/", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
            $line = preg_replace("/^E_WARNING/", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
            $line = preg_replace("/^E_ERROR/", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);
            $line = preg_replace("/^E_USER_NOTICE/", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
            $line = preg_replace("/^E_USER_WARNING/", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
            $line = preg_replace("/^E_USER_ERROR/", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);
            $line = preg_replace("/^(\w*)Exception/", "<span class='lh-badge' style='background-color: #a71616;'>Exception:</span> ", $line);
            $line = preg_replace("/^(\w*)Error/", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

            // Save the log entry
            $logs[$time][] = $line;
        }
    }
}
