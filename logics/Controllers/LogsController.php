<?php

namespace Logics\Controllers;

use Logics\Services\Parsers;

class LogsController
{
    private $parsersService;

    public function __construct(Parsers $parsersService)
    {
        $this->parsersService = $parsersService;
    }

    public function countAll(&$countAll)
    {
        $countAll = $this->parsersService->countAll();
    }

    public function handleDefault(&$countAll)
    {
        if (empty($countAll)) {
            reload(buildUrl('display/start'));
        }
        reload(buildUrl('display/info'));
    }

    public function view(&$pageTitle, &$views, $file)
    {
        $logs = $this->parsersService->view($file);
        $pageTitle = $logs['title'] ?? '';
        $views[] = ROOT . "views/parsers/log_reader.php";
        return $logs;
    }

    public function truncate($file)
    {
        $this->parsersService->truncate($file);
        reload(buildUrl("viewlog/" . $file));
    }
}
