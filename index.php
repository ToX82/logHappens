<?php
include "libs/libs.php";
init();
benchmark();

include "routers/router.php";
include "layouts/default.php";
?>

<!-- <?= benchmark(); ?> sec. <?= convert(memory_get_usage()) ?> mem. -->
