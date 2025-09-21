<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'libs/libs.php';

\Libs\init();

include ROOT . "routers/router.ajax.php";

echo $return;
