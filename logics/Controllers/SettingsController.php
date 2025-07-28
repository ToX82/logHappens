<?php

namespace Logics\Controllers;

class SettingsController
{
    public function write($parameter, $selected)
    {
        writeSettingsCookie($parameter, $selected);

        if (isset($_SERVER['HTTP_REFERER'])) {
            reload($_SERVER['HTTP_REFERER']);
        }

        reload('/');
    }
}
