<?php
// Search for your own icons here: https://iconify.design/
$parsers = [
    "apache" => [
        "icon" => "logos:apache",
        "color" => "red",
        "title" => "Apache error.log",
        "file" => "/var/log/apache2/error.log",
        "parser" => "apache24"
    ],
    "remote" => [
        "icon" => "whh:remotemysql",
        "color" => "#7BE269",
        "title" => "Remote example",
        "file" => "http://example.com/logs/error.log",
        "parser" => "cakephp"
    ],
];
