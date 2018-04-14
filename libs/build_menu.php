<?php
$files = glob("logics/*.php");
$menuItems = [];
foreach ($files as $file) {
    include($file);
    $filename = basename($file, ".php");

    $menuItems[$filename] = $menu;
    $menuItems[$filename]["count"] = count($logs);
    $menuItems[$filename]["logs"] = [];

    if ($filename == $logic) {
        // Only save the active logs in the array.
        $logs = array_slice($logs, 0, $_SESSION["pagelength"]);
        $menuItems[$filename]["logs"] = $logs;
    }
}
