<?php
$action = null;
$logic = null;
$page = "contents/pages/info.php";

if (checkExist("action")) {
    $action = filterString("action");
    include("contents/actions/" . $action . ".php");
}

if (checkExist("logic")) {
    $logic = filterString("logic");

    if (is_file("logics/" . $logic . ".php")) {
        include("logics/" . $logic . ".php");
    } else {
        $page = "contents/pages/404.php";
    }
}

if (checkExist("page") && $page !== "contents/pages/404.php") {
    $page = filterString("page");

    if (is_file("contents/pages/" . $page . ".php")) {
        $page = "contents/pages/" . $page . ".php";
    } else {
         $page = "contents/pages/404.php";
    }
}
