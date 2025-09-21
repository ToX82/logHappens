<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'libs/libs.php';

\Libs\init();
\Libs\Utilities::benchmark();

include ROOT . "routers/router.php";
include ROOT . "views/layouts/default.php";
?>

<!-- <?= \Libs\Utilities::benchmark(); ?> sec. <?= \Libs\Utilities::convert(memory_get_usage()) ?> mem. -->
