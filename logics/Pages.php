<?php

namespace Logics;

class Pages
{
    /**
     * Displays a static page
     *
     * @param string $page The page we want to display. 404.php if the page does not exist
     * @return string
     */
    public static function display($page)
    {
        if (is_file(ROOT . "views/pages/" . $page . ".php")) {
            return "views/pages/" . $page . ".php";
        }

        return "views/pages/404.php";
    }
}
