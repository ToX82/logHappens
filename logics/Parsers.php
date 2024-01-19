<?php

namespace Logics;

class Parsers
{
    public $config = '';

    /**
     * Constructor for the class.
     *
     * @param string $jsonFile The path to the JSON file.
     * @return void
     */
    public function __construct()
    {
        $config = [];

        if (!is_file(ROOT . 'config.json')) {
            reload('config_error.html');
        }

        $config = file_get_contents(ROOT . 'config.json');
        $config = json_decode($config, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            reload('config_error.html');
        }

        if (isset($config['parsers'])) {
            $config = $this->checkDatedLogFiles($config['parsers']);
        }

        // for each parser, let's check if the file exists, if not, let's remove it from the list
        foreach ($config as $key => $parser) {
            if (!is_file($parser['file'])) {
                unset($config[$key]);
            }

            // if the config has a "disabled" key, let's remove it from the list
            if (isset($parser['disabled']) && $parser['disabled'] === true) {
                unset($config[$key]);
            }
        }

        $this->config = $config;
    }

    /**
     * Checks for dated log files (eg. the ones used in codeigniter) and returns the compiled today's log path
     *
     * @param array $parsers Parsers
     * @return array
     */
    public function checkDatedLogFiles($parsers)
    {
        $placeholders = [
            'Y', // A full numeric representation of a year, 4 digits
            'y', // A two digit representation of a year
            'm', // Numeric representation of a month, with leading zeros
            'n', // Numeric representation of a month, without leading zeros
            'd', // Day of the month, 2 digits with leading zeros
            'j' // Day of the month without leading zeros
        ];

        // For each placeholder, for each parser file, let's check if there is something to replace
        foreach ($placeholders as $placeholder) {
            foreach ($parsers as $key => $parser) {
                if (strpos($parser['file'], '{' . $placeholder . '}') !== false) {
                    $parsers[$key]['file'] = str_replace('{' . $placeholder . '}', date($placeholder), $parsers[$key]['file']);
                }
            }
        }

        return $parsers;
    }

    /**
     * List available logs from the configuration file
     *
     * @return array
     */
    public function listLogs()
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
     * @return int|string
     */
    public function count($file)
    {
        $logs = [];
        $data = $this->config[$file];
        $file = ROOT . "parsers/" . $data['parser'] . ".php";
        if (is_file($file)) {
            include $file;
        }

        if (count($logs) === 0) {
            return '';
        }

        return count($logs);
    }

    /**
     * Returns the entries for a given log file
     *
     * @param string $file Log file
     * @return array
     */
    public function view($file)
    {
        $data = $this->config[$file];

        return [
            'file' => $file,
            'icon' => $data['icon'],
            'color' => $data['color'],
            'writable' => is_writable($data['file']),
            'title' => $data['title'],
        ];
    }

    /**
     * Returns the entries for a given log file
     *
     * @param string $file Log file
     * @param int $offset Offset
     * @param int $limit Limit
     * @return array
     */
    public function entries($file, $offset = 0, $limit = 10, $search = '')
    {
        $logs = [];
        $data = $this->config[$file];
        include ROOT . "parsers/" . $data['parser'] . ".php";

        // We want the records ordered from the newest to the oldest
        if (count($logs) > 0) {
            $logs = array_reverse($logs);
        }

        // Setting the total records count
        $recordsTotal = count($logs);

        // Is there anything to search?
        if ($search !== '') {
            foreach ($logs as $key => $log) {
                $found = false;

                if (strpos($key, $search) !== false) {
                    $found = true;
                }

                foreach ($log as $line) {
                    if (stripos($line, $search) !== false) {
                        $found = true;
                    }
                }

                if ($found === false) {
                    unset($logs[$key]);
                }
            }
        }

        // The filtered records could be different from the total, if we are searching for something
        $recordsFiltered = count($logs);

        // Subsetting the records for pagination
        $subset = array_slice($logs, $offset, $limit);

        return ['recordsFiltered' => $recordsFiltered, 'recordsTotal' => $recordsTotal, 'data' => $subset];
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
