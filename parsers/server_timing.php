<?php

$content = openFileOrDie($data['file']);

$logs = [];
$time = '';
foreach ($content as $line) {
    if (substr($line, 0, 1) != "[") {
        $logs[$time][] = str_replace("\n", "", $line);
    } else {
        // Grab the log's time and group logs by time
        $time = date('Y-m-d H:i:s');

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
            $line = str_replace('\n', '<br>', $line);
            $line = preg_replace('/^   /', '', $line);

            // remove everything after ", referer: "
            $line = preg_replace('/, referer: .*/', '', $line);

            // remove trailing spaces at the end of the line
            $line = preg_replace('/\s+$/m', '', $line);

            // if the line doesn't contain "Server-Timing: ", drop it
            if (strpos($line, 'Server-Timing: ') === false) {
                continue;
            }

            // remove the string ServerTiming:
            $line = str_replace('Server-Timing: ', '', $line);

            // Save the log entry
            $logs[$time][] = $line;
        }
    }
}
