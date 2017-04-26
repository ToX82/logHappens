<?php
$action = null;
$logic = null;
$page = null;
$notfound = false;

if (checkExist('action')) {
    $action = filterString('action');
    include("contents/actions/" . $action . ".php");
}
if (checkExist('logic')) {
    $logic = filterString('logic');

    if (is_file("logics/" . $logic . ".php")) {
        include("logics/" . $logic . ".php");
    } else {
        include("contents/pages/404.php");
        $notfound = true;
    }
}
if (checkExist('page')) {
    $page = filterString('page');

     if (is_file("contents/pages/" . $page . ".php")) {
        $page = 'contents/pages/'. $page .'.php';
     } else {
         include("contents/pages/404.php");
         unset($page);
     }
}

if ($page === null || $notfound === true) {
    $page = 'contents/pages/info.php';
}
