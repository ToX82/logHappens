<?php
$objParsers = new logics\Parsers();
$return = null;

if (isset($_GET['countlog'])) {
    $file = $_GET['file'];
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    $return = $objParsers->count($file);
}
if (isset($_GET['viewlog'])) {
    $file = $_GET['file'];
    $file = filter_var($file, FILTER_SANITIZE_STRING);
    $logs = $objParsers->read($file);
    include("templates/parsers/log_reader.php");
}
