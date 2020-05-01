<?php
$objParsers = new logics\Parsers(BASE_PATH . "config.json");
$return = null;

if (isset($_GET['countall'])) {
    $return = $objParsers->countAll();
    $return = json_encode($return);
}
if (isset($_GET['viewlog'])) {
    $file = filter_var($_GET['file'], FILTER_SANITIZE_STRING);
    $offset = filter_var($_GET['start'], FILTER_SANITIZE_STRING);
    $limit = filter_var($_GET['length'], FILTER_SANITIZE_STRING);
    $search = filter_var($_GET['search']['value'], FILTER_SANITIZE_STRING);
    $return = $objParsers->entries($file, $offset, $limit, $search);
    $return = include('templates/parsers/getdata.php');
}
