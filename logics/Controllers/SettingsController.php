<?php

declare(strict_types=1);

namespace Logics\Controllers;

use Libs\UrlHelper;
use Libs\Utilities;

class SettingsController
{
    public function write(string $parameter, string $selected): void
    {
        Utilities::writeSettingsCookie($parameter, $selected);

        $referer = (string)($_SERVER['HTTP_REFERER'] ?? '');
        $base = UrlHelper::baseUrl();
        if ($referer !== '' && str_starts_with($referer, $base)) {
            UrlHelper::reload($referer);
            return;
        }

        UrlHelper::reload('/');
    }
}
