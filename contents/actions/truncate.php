<?php
$logFile = filterString('logFile');

if ($logFile != "" && is_file($logFile)) {
    // If the file is writeable, truncate its content and refresh the page
    file_put_contents($logFile, null);
    redirect($_SERVER['HTTP_REFERER']);
} else {
    redirect('index.php?page=no_permissions');
}
