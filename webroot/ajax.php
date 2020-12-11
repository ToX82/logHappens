<?php

define('ROOT', realpath('../') . '/');

include ROOT . "libs/libs.php";
init();

include ROOT . "routers/router.ajax.php";

echo $return;
