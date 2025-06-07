<?php

namespace Logics;

class Parsers
{
    private $config = [];
    private const CONFIG_PATH = ROOT . 'config.json';

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        if (!is_file(self::CONFIG_PATH)) {
            reload('config_missing.html');
        }

        if (!is_writeable(self::CONFIG_PATH)) {
            reload('config_readonly.html');
        }

        $configContent = file_get_contents(self::CONFIG_PATH);
        $config = json_decode($configContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            reload('config_error.html');
        }

        if (isset($config['parsers'])) {
            $config['parsers'] = $this->checkDatedLogFiles($config['parsers']);
        }

        $this->config = array_filter($config['parsers'], function ($parser) {
            return is_file($parser['file']) && !(isset($parser['disabled']) && $parser['disabled'] === true);
        });
    }

    /**
     * Checks for dated log files (eg. the ones used in codeigniter) and returns the compiled today's log path.
     *
     * @param array $parsers Parsers
     * @return array
     */
    private function checkDatedLogFiles(array $parsers): array
    {
        $placeholders = [
            'Y', 'y', 'm', 'n', 'd', 'j'
        ];

        foreach ($parsers as $key => $parser) {
            foreach ($placeholders as $placeholder) {
                if (strpos($parser['file'], "{{$placeholder}}") !== false) {
                    $parsers[$key]['file'] = str_replace("{{$placeholder}}", date($placeholder), $parser['file']);
                }
            }
        }

        return $parsers;
    }

    /**
     * List available logs from the configuration file.
     *
     * @return array
     */
    public function listLogs(): array
    {
        return $this->config;
    }

    /**
     * Recount all of the tracked log files.
     *
     * @return array
     */
    public function countAll(): array
    {
        $counts = [];
        foreach ($this->config as $key => $config) {
            $counts[$key] = $this->count($key);
        }

        return $counts;
    }

    /**
     * Counts the number of entries for a given log file.
     *
     * @param string $file Log file
     * @return int|string
     */
    public function count(string $file)
    {
        if (!isset($this->config[$file])) {
            return '';
        }

        $logs = $this->getLogs($file);
        return count($logs) ? count($logs) : '';
    }

    /**
     * Returns the entries for a given log file.
     *
     * @param string $file Log file
     * @return array
     */
    public function view(string $file): array
    {
        $data = $this->config[$file];

        return [
            'file' => $file,
            'icon' => $data['icon'],
            'color' => $data['color'],
            'writable' => is_writable($data['file']),
            'truncatable' => $data['truncatable'] ?? true,
            'title' => $data['title'],
        ];
    }

    /**
     * Returns the entries for a given log file with optional search and pagination.
     *
     * @param string $file Log file
     * @param int $offset Offset
     * @param int $limit Limit
     * @param string $search Search term
     * @return array
     */
    public function entries(string $file, int $offset = 0, int $limit = 10, string $search = ''): array
    {
        $logs = $this->getLogs($file);

        // We want the records ordered from the newest to the oldest
        $logs = array_reverse($logs);

        // Setting the total records count
        $recordsTotal = count($logs);

        // Is there anything to search?
        if ($search !== '') {
            $logs = array_filter($logs, function ($log) use ($search) {
                foreach ($log as $line) {
                    if (stripos($line, $search) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }

        // The filtered records could be different from the total, if we are searching for something
        $recordsFiltered = count($logs);

        // Subsetting the records for pagination
        $subset = array_slice($logs, $offset, $limit);

        return ['recordsFiltered' => $recordsFiltered, 'recordsTotal' => $recordsTotal, 'data' => $subset];
    }

    /**
     * Truncates a log file.
     *
     * @param string $file Log file to truncate
     * @return void
     */
    public function truncate(string $file): void
    {
        if (!isset($this->config[$file])) {
            reload('404');
        }

        $data = $this->config[$file];
        file_put_contents($data['file'], "");
    }

    /**
     * Gets the logs for a given file.
     *
     * @param string $file Log file
     * @return array
     */
    private function getLogs(string $file): array
    {
        $logs = [];
        if (isset($this->config[$file])) {
            $data = $this->config[$file];
            $parserFile = ROOT . "parsers/" . $data['parser'] . ".php";
            if (is_file($parserFile)) {
                include $parserFile;
            }
        }
        return $logs;
    }
}
