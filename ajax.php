<?php
include "config.php";
include "libs/libs.php";
init();

include "routers/router.ajax.php";

echo $return;
