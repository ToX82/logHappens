<?php
$files = glob("logics/*.php");
$menu_items = [];
foreach ($files as $file) {
    include($file);
    $filename = basename($file, ".php");

    $menu_items[$filename] = $menu;
    $menu_items[$filename]["count"] = count($logs);
    $menu_items[$filename]["logs"] = [];

    if ($filename == $logic) {
        // Only save the active logs in the array.
        $logs = array_slice($logs, 0, $_SESSION["pagelength"]);
        $menu_items[$filename]["logs"] = $logs;
    }
}
