<?php
$length = $_GET['length'];
if (is_numeric($length)) {
    $_SESSION['pagelength'] = $length;
}
