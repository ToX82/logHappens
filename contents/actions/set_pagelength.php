<?php
$length = filterInt("length");
if ($length != "") {
    $_SESSION["pagelength"] = $length;
}
