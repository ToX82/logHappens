<?php

declare(strict_types=1);

namespace Logics\Controllers;

use Libs\UrlHelper;
use Logics\Services\Parsers;

class LogsController
{
    private $parsersService;

    public function __construct(Parsers $parsersService)
    {
        $this->parsersService = $parsersService;
    }

    public function countAll(&$countAll): void
    {
        $countAll = $this->parsersService->countAll();
    }

    public function handleDefault(&$countAll): void
    {
        if (empty($countAll)) {
            UrlHelper::reload(UrlHelper::buildUrl('display/start'));
        }
        UrlHelper::reload(UrlHelper::buildUrl('display/info'));
    }

    public function view(&$pageTitle, &$views, string $file): array
    {
        $logs = $this->parsersService->view($file);
        $pageTitle = $logs['title'] ?? '';
        $views[] = ROOT . 'views/parsers/log_reader.php';
        return $logs;
    }

    public function truncate(string $file): void
    {
        $this->parsersService->truncate($file);
        UrlHelper::reload(UrlHelper::buildUrl('viewlog/' . $file));
    }
}
