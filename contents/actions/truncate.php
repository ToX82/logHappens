<?php
include('../libs/libs.php');

$logFile = filterString('logFile');
if ($logFile != "" && is_file($logFile)) {
    file_put_contents($logFile, null);
    redirect($_SERVER['HTTP_REFERER']);
    die;
}
echo "Unable to truncate this file. Please check that it's writeable by apache. <a href='javascript:history.back();'>Back</a>";
