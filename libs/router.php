<?php
if (isset($_GET['logic'])) {
    if (is_file("logics/{$_GET['logic']}.php")) {
        include("logics/{$_GET['logic']}.php");
    }
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $page = 'views/pages/'. $page .'.php';
}

if (!isset($page) || !is_file($page)) {
    $page = 'views/pages/info.php';
}
