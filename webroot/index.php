<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

if (!is_file(ROOT . 'vendor/autoload.php')) {
    echo file_get_contents(ROOT . 'webroot/firstrun.html');
    die;
}

require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'libs/libs.php';

\Libs\init();
\Libs\Utilities::benchmark();

include ROOT . "routers/router.php";
include ROOT . "views/layouts/default.php";
?>

<!-- <?= \Libs\Utilities::benchmark(); ?> sec. <?= \Libs\Utilities::convert(memory_get_usage()) ?> mem. -->
