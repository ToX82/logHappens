<?php
// Search for your own icons here: https://iconify.design/
$parsers = [
    'apache' => [
        'icon' => 'logos:apache',
        'color' => '#104B73',
        'title' => 'Apache error',
        'file' => '/var/log/apache2/error.log',
        "parser" => "apache24"
    ],
    'fatt_debug' => [
        "icon" => "ion:ios-send",
        "color" => "#1BB7A0",
        "title" => "Fatturazione debug",
        "file" => "/var/www/fatturazione/logs/debug.log",
        "parser" => "cakephp3"
    ],
    'fatt_error' => [
        "icon" => "ion:ios-send",
        "color" => "#1BB7A0",
        "title" => "Fatturazione errors",
        "file" => "/var/www/fatturazione/logs/error.log",
        "parser" => "cakephp3"
    ],
    'fatt_javascript' => [
        "icon" => "ion:ios-send",
        "color" => "#1BB7A0",
        "title" => "Fatturazione javascript",
        "file" => "/var/www/fatturazione/logs/javascript.log",
        "parser" => "cakephp3"
    ],
    '1dogsports' => [
        "icon" => "whh:dog",
        "color" => "#104B73",
        "title" => "1 DogSports",
        "file" => "http://localhost/1dogsports/log_reader.php",
        "parser" => "codeigniter"
    ],
    'csen_debug' => [
        "icon" => "whh:dog",
        "color" => "#104B73",
        "title" => "CSEN debug",
        "file" => "/var/www/csen/httpdocs/app/tmp/logs/debug.log",
        "parser" => "cakephp3"
    ],
    'csen_error' => [
        "icon" => "whh:dog",
        "color" => "#104B73",
        "title" => "CSEN errors",
        "file" => "/var/www/csen/httpdocs/app/tmp/logs/error.log",
        "parser" => "cakephp3"
    ],
    'enci_debug' => [
        "icon" => "whh:dog",
        "color" => "#1A5AA6",
        "title" => "Sport.Enci debug",
        "file" => "/var/www/enci/app/tmp/logs/debug.log",
        "parser" => "cakephp3"
    ],
    'enci_error' => [
        "icon" => "whh:dog",
        "color" => "#1A5AA6",
        "title" => "Sport.Enci errors",
        "file" => "/var/www/enci/app/tmp/logs/error.log",
        "parser" => "cakephp3"
    ]
];
