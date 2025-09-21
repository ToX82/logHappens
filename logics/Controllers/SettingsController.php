<?php

namespace Logics\Controllers;

use Libs\UrlHelper;
use Libs\Utilities;

class SettingsController
{
    public function write($parameter, $selected)
    {
        Utilities::writeSettingsCookie($parameter, $selected);

        if (isset($_SERVER['HTTP_REFERER'])) {
            UrlHelper::reload($_SERVER['HTTP_REFERER']);
        }

        UrlHelper::reload('/');
    }
}
