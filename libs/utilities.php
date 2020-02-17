<?php
/**
 * Trasforma la data in formato leggibile
 *
 * @param string $date Data
 * @return string
 */
function toDateTime($date)
{
    if ($date === '0000-00-00') {
        return '-';
    }

    return date("l d-m-Y - H:i:s", strtotime($date));
}

/**
 * Time tracker
 *
 * @return float
 */
function benchmark()
{
    static $start = null;

    if (is_null($start)) {
        $start = getmicrotime();
    } else {
        $benchmark = getmicrotime() - $start;
        $start = getmicrotime();

        return round($benchmark, 2);
    }
}

/**
 * Get timestamp
 *
 * @return timestamp
 */
function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());

    return ((float)$usec + (float)$sec);
}

/**
 * Convert memory size in human readable format
 *
 * @param int $size Size
 * @return float
 */
function convert($size)
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}
