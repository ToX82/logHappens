<?php
include("libs/libs.php");
include("libs/router.php");

$logic = "";
$page = "info";

if (checkExist('logic')) {
    $logic = filterString('logic');
    include("logics/" . $logic . ".php");
}
if (checkExist('page')) {
    $page = filterString('page');
    include("views/pages/" . $page . ".php");
}
