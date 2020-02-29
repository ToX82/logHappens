<?php
$objParsers = new logics\Parsers(BASE_PATH . "config.json");
$return = null;

if (isset($_GET['countall'])) {
    $return = $objParsers->countAll();
    $return = json_encode($return);
}
if (isset($_GET['viewlog'])) {
    $file = $_GET['file'];
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    $logs = $objParsers->read($file);
    include "templates/parsers/log_reader.php";
}
