<?php
if (checkExist('logic')) {
    if (is_file("logics/" . filterString('logic') . ".php")) {
        include("logics/" . filterString('logic') . ".php");
    } else {
        include("views/pages/404.php");
        $notfound = true;
    }
}
if (checkExist('page')) {
     if (is_file("views/pages/" . filterString('page') . ".php")) {
        $page = 'views/pages/'. filterString('page') .'.php';
     } else {
         include("views/pages/404.php");
         unset($page);
     }
}

if (!isset($page) || isset($notfound)) {
    $page = 'views/pages/info.php';
}
