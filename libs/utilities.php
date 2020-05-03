<?php
/**
 * Transforms the date in a localized readable format
 *
 * @param string $date Date
 * @return string
 */
function toDateTime($date)
{
    if ($date === '0000-00-00') {
        return '-';
    }

    $lang = getBrowserLanguage();
    $fmt = new \IntlDateFormatter($lang, IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
    return $fmt->format(strtotime($date));
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

function randomError()
{
    $haiku = [
        "A page like that?<br>It might be very useful.<br>But now it is gone.",
        "The Web page you seek<br>Cannot be located, but<br>Countless more exist.",
        "Program aborting:<br>Close all that you have worked on.<br>You ask far too much.",
        "Yesterday it worked.<br>Today it is not working.<br>Servers are like that.",
        "Stay the patient course.<br>Of little worth is your ire.<br>This page is offline.",
        "You step in the stream,<br>But the water has moved on.<br>This page is not here.",
        "Out of memory.<br>We wish to hold the whole sky,<br>But we never will.",
        "Having been erased,<br>The document you’re seeking<br>Must now be retyped.",
        "Serious error.<br>All shortcuts have disappeared.<br>Screen. Mind. Both are blank.",
        "Something you entered<br>transcended parameters.<br>So much is unknown.",
        "Not a pretty sight<br>When the web dies screaming loud<br>The page is not found.",
        "The web page you seek<br>Lies beyond our perception<br>But others await.",
        "Rather than a beep<br>Or a rude error message,<br>These words: 'Page not found.'",
        "To have no errors<br>Would be life without meaning<br>No struggle, no joy",
        "Errors have occurred.<br>We won't tell you where or why.<br>Lazy programmers.",
        "The code was willing<br>It considered your request,<br>But the chips were weak.",
    ];

    return $haiku[array_rand($haiku)];
}
