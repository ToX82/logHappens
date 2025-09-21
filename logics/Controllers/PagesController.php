<?php

namespace Logics\Controllers;

use Libs\UrlHelper;
use Logics\Services\Pages;

class PagesController
{
    public function display(&$pageTitle, &$views, $displayPage, $countAll)
    {
        $pageTitle = ucfirst($displayPage);

        if ($displayPage === 'start') {
            if (!empty($countAll)) {
                UrlHelper::reload(UrlHelper::buildUrl('/display/info'));
            }
        }

        $file = Pages::display($displayPage);
        $views[] = ROOT . $file;
    }
}
