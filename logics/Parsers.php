<?php

namespace Logics;

class Parsers
{
    public $config = '';

    /**
     * __construct
     */
    public function __construct($jsonFile)
    {
        $config = [];

        if (is_file($jsonFile)) {
            $config = file_get_contents($jsonFile);
            $config = json_decode($config, true);

            if (isset($config['parsers'])) {
                $config = $this->checkDatedLogFiles($config['parsers']);
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
        $data = $this->config[$file];
        include ROOT . "parsers/" . $data['parser'] . ".php";

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
        $data = $this->config[$file];
        include ROOT . "parsers/" . $data['parser'] . ".php";

        // We want the records ordered from the newest to the oldest
        if (!empty($logs)) {
            $logs = array_reverse($logs);
        }

        // Setting the total records count
        $recordsTotal = count($logs);

        // Is there anything to search?
        if ($search !== '') {
            foreach ($logs as $key => $log) {
                $found = false;
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
