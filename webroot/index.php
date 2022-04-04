<?php

define('ROOT', realpath('../') . DIRECTORY_SEPARATOR);

include ROOT . "libs/libs.php";
init();
benchmark();

include ROOT . "routers/router.php";
include ROOT . "views/layouts/default.php";
?>

<!-- <?= benchmark(); ?> sec. <?= convert(memory_get_usage()) ?> mem. -->
