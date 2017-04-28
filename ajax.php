<?php
include("libs/libs.php");
include("libs/router.php");
include("libs/build_menu.php");

$logic = "";
$page = "info";

if (checkExist('logic')) {
    $logic = filterString('logic');
    include("logics/" . $logic . ".php");
}
if (checkExist('page')) {
    $page = filterString('page');
    include("contents/pages/" . $page . ".php");
}
