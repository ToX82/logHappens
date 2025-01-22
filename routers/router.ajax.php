<?php

$objParsers = new Logics\Parsers(ROOT . "config.json");
$return = null;

if (isset($_GET['countall'])) {
    $return = $objParsers->countAll();
    $return = json_encode($return);
}
if (isset($_GET['viewlog'])) {
    $file = filter_var($_GET['file'], FILTER_DEFAULT);
    $offset = filter_var($_GET['start'], FILTER_SANITIZE_NUMBER_INT);
    $limit = filter_var($_GET['length'], FILTER_SANITIZE_NUMBER_INT);
    $search = filter_var($_GET['search']['value'], FILTER_DEFAULT);
    $return = $objParsers->entries($file, $offset, $limit, $search);
    $return = include(ROOT . 'views/parsers/getdata.php');
}
if (isset($_GET['check-file-exists'])) {
    $objConfig = new Logics\Configurations();
    $filename = filter_var($_POST['filename'], FILTER_DEFAULT);
    $return = $objConfig->checkFileExists($filename);
    $return = json_encode($return);
}
if (isset($_GET['change-visibility'])) {
    $objConfig = new Logics\Configurations();
    $return = $objConfig->changeVisibility($_POST['configName']);

    $return = json_encode($return);
}

if (isset($_GET['update-order'])) {
    $objConfig = new Logics\Configurations();
    $order = json_decode($_POST['order'], true);
    $return = $objConfig->updateOrder($order);

    $return = json_encode($return);
}
