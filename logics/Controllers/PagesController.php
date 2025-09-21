<?php

declare(strict_types=1);

namespace Logics\Controllers;

use Libs\UrlHelper;
use Logics\Services\Pages;

class PagesController
{
    public function display(&$pageTitle, &$views, string $displayPage, $countAll): void
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
