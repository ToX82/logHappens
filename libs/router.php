<?php
if (checkExist('logic')) {
    if (is_file("logics/" . filterString('logic') . ".php")) {
        include("logics/" . filterString('logic') . ".php");
    }
}
if (checkExist('page')) {
    $page = filterString('page');
    $page = 'views/pages/'. $page .'.php';
}

if (!isset($page) || !is_file($page)) {
    $page = 'views/pages/info.php';
}
