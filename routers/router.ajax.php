<?php

$objParsers = new logics\Parsers(ROOT . "config.json");
$return = null;

if (isset($_GET['countall'])) {
    $return = $objParsers->countAll();
    $return = json_encode($return);
}
if (isset($_GET['viewlog'])) {
    $file = filter_var($_GET['file'], FILTER_SANITIZE_STRING);
    $offset = filter_var($_GET['start'], FILTER_SANITIZE_NUMBER_INT);
    $limit = filter_var($_GET['length'], FILTER_SANITIZE_NUMBER_INT);
    $search = filter_var($_GET['search']['value'], FILTER_SANITIZE_STRING);
    $return = $objParsers->entries($file, $offset, $limit, $search);
    $return = include(ROOT . 'views/parsers/getdata.php');
}
if (isset($_GET['check-file-exists'])) {
    $objConfig = new logics\Configurations();
    $filename = filter_var($_POST['filename'], FILTER_SANITIZE_STRING);
    $return = $objConfig->checkFileExists($filename);
    $return = json_encode($return);
}
if (isset($_GET['change-visibility'])) {
    $objConfig = new logics\Configurations();
    $return = $objConfig->changeVisibility($_POST['configName']);

    $return = json_encode($return);
}
