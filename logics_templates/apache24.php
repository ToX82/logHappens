<?php
$menu = [
    'icon' => 'logos:apache',
    'color' => 'red',
    'title' => 'Apache error.log',
    'file' => '/var/log/apache2/error.log'
];
if (!is_readable($menu['file'])) {
    echo 'Unable to open the log file. Please check that the file is <a href="http://serverfault.com/questions/663837/make-error-log-readable-by-apache">readable by apache.</a>';
    die;
}

$content = file($menu['file']);

$log = [];
$time = '';
foreach ($content as $line) {
    if (substr($line, 0, 1) != "[") {
        $log[$time][] = str_replace("\n", "", $line);
    } else {
        // Grab the log's time and group logs by time
        $time = substr($line, 1, 19);
        $time = date("l d-m-Y - H:i:s", strtotime($time));

        if ($time != '') {
            // Remove date-time and other useless informations from the log details
            $line = substr($line, 34);
            $line = preg_replace('[\[:error(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[pid (.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[php7(.*?)\]]', '', $line, 1);
            $line = preg_replace('[\[client(.*?)\]]', '', $line, 1);
            $line = str_replace('PHP', '', $line);
            $line = str_replace('\n', '<br>', $line);
            $line = trim($line);

            // Highlight the type of errors, using a badge
            $line = preg_replace("/^Notice: /", "<span class='lh-badge' style='background-color: #318418;'>Notice:</span> ", $line);
            $line = preg_replace("/^Warning: /", "<span class='lh-badge' style='background-color: #a79716;'>Warning:</span> ", $line);
            $line = preg_replace("/^Fatal error: /", "<span class='lh-badge' style='background-color: #a71616;'>Fatal error:</span> ", $line);
            $line = preg_replace("/^Parse error: /", "<span class='lh-badge' style='background-color: #a71616;'>Parse error:</span> ", $line);
            $line = preg_replace("/^Error: /", "<span class='lh-badge' style='background-color: #a71616;'>Error:</span> ", $line);

            // Save the log entry
            $log[$time][] = $line;
        }
    }
}

// Reverse the logs, so that we can see last errors first
$logs = array_reverse($log);
