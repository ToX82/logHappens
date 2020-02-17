<?php
namespace Logics;

class Parsers
{
    public $config = '';

    /**
     * __construct
     */
    public function __construct()
    {
        $parsers = [];

        if (is_file(BASE_PATH . "config.php")) {
            include BASE_PATH . "config.php";
        }

        $this->config = $parsers;
    }

    /**
     * List available logs from the configuration file
     *
     * @return array
     */
    public function list()
    {
        return $this->config;
    }

    /**
     * Recount all of the tracked log files
     *
     * @return array
     */
    public function countAll()
    {
        $counts = [];
        foreach ($this->config as $key => $config) {
            $counts[$key] = $this->count($key);
        }

        return $counts;
    }

    /**
     * Counts the number of entries for a given log file
     *
     * @param string $file Log file
     * @return int
     */
    public function count($file)
    {
        $logs = $this->read($file);

        if (count($logs['entries']) === 0) {
            return '';
        }

        return count($logs['entries']);
    }

    /**
     * Returns the entries for a given log file
     *
     * @param string $file Log file
     * @return array
     */
    public function read($file)
    {
        $data = $this->config[$file];
        include BASE_PATH . "parsers/" . $data['parser'] . ".php";

        if (!empty($logs)) {
            $logs = array_reverse($logs);
        }

        return [
            'file' => $file,
            'writable' => is_writable($data['file']),
            'title' => $data['title'],
            'entries' => $logs,
        ];
    }

    /**
     * Truncates a log file
     *
     * @param string $file Log file to truncate
     * @return void
     */
    public function truncate($file)
    {
        if (!isset($this->config[$file])) {
            reload('404');
        }

        $data = $this->config[$file];
        file_put_contents($data['file'], "");
    }
}
