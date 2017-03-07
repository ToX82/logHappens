<?php
include("libs/libs.php");
include("libs/router.php");

$logic = "";
$page = "info";

if (isset($_GET['logic'])) {
    $logic = $_GET['logic'];
    include("logics/{$logic}.php");
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    include('views/pages/'. $page .'.php');
}
