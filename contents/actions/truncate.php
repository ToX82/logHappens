<?php
$logFile = filterString('logFile');

if ($logFile != "" && is_file($logFile)) {
    // If the file is writeable, truncate its content and refresh the page
    file_put_contents($logFile, null);
    redirect($_SERVER['HTTP_REFERER']);
}

// Else, show a message
echo "Unable to truncate this file. Please check that it's writeable by apache. <a href='javascript:history.back();'>Back</a>";
