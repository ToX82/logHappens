<?php
if (checkExist('action')) {
    include("contents/actions/" . filterString('action') . ".php");
}
if (checkExist('logic')) {
    if (is_file("logics/" . filterString('logic') . ".php")) {
        include("logics/" . filterString('logic') . ".php");
    } else {
        include("contents/pages/404.php");
        $notfound = true;
    }
}
if (checkExist('page')) {
     if (is_file("contents/pages/" . filterString('page') . ".php")) {
        $page = 'contents/pages/'. filterString('page') .'.php';
     } else {
         include("contents/pages/404.php");
         unset($page);
     }
}

if (!isset($page) || isset($notfound)) {
    $page = 'contents/pages/info.php';
}
