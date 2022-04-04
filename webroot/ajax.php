<?php
// get operating system's directory separator
define('ROOT', realpath('../') . DIRECTORY_SEPARATOR);

include ROOT . "libs/libs.php";
init();

include ROOT . "routers/router.ajax.php";

echo $return;
