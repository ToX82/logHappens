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

/**
 * List settings
 *
 * @param $parameter Which parameters we need
 * @return array
 */
function listSettings($parameter)
{
    $data = [
        'theme' => [
            'default' => 'bootstrap',
            'options' => [
                'bootstrap',
                'cerulean',
                'darkly',
                'litera',
                'materia',
                'sandstone',
                'slate',
                'superhero',
                'cosmo',
                'flatly',
                'lumen',
                'minty',
                'simplex',
                'solar',
                'united',
                'cyborg',
                'journal',
                'lux',
                'pulse',
                'sketchy',
                'spacelab',
                'yeti',
            ],
        ],
        'refresh' => [
            'default' => 5,
            'options' => [
                '5',
                '15',
                '30',
                '60',
                '120',
            ],
        ],
        'page-length' => [
            'default' => 10,
            'options' => [
                '10',
                '25',
                '50',
                '100',
            ]
        ]
    ];

    return $data[$parameter];
}

/**
 * Gets the user selected theme
 *
 * @return void
 */
function setting($parameter)
{
    if (isset($_COOKIE[$parameter])) {
        $selected = $_COOKIE[$parameter];
    } else {
        $settings = listSettings($parameter);
        $selected = $settings['default'];
        $selected = writeSettingsCookie($parameter, $selected);
    }

    return $selected;
}

/**
 * Writes the user's selected theme into a cookie
 *
 * @param string $theme selected theme
 * @return string
 */
function writeSettingsCookie($parameter, $selected)
{
    $settings = listSettings($parameter);

    if (!in_array($selected, $settings['options'])) {
        $selected = $settings['default'];
    }

    setcookie($parameter, $selected, strtotime('+1 year'), '/');

    return $selected;
}

/**
 * Select a random 404 error
 *
 * @return string
 */
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

function normalizeChars($inputString)
{
    $fix_list = array(
        // 3 char errors first
        'â€š' => '‚', 'â€ž' => '„', 'â€¦' => '…', 'â€¡' => '‡',
        'â€°' => '‰', 'â€¹' => '‹', 'â€˜' => '‘', 'â€™' => '’',
        'â€œ' => '“', 'â€¢' => '•', 'â€“' => '–', 'â€”' => '—',
        'â„¢' => '™', 'â€º' => '›', 'â‚¬' => '€',
        // 2 char errors
        'Ã‚'  => 'Â', 'Æ’'  => 'ƒ', 'Ãƒ'  => 'Ã', 'Ã„'  => 'Ä',
        'Ã…'  => 'Å', 'â€'  => '†', 'Ã†'  => 'Æ', 'Ã‡'  => 'Ç',
        'Ë†'  => 'ˆ', 'Ãˆ'  => 'È', 'Ã‰'  => 'É', 'ÃŠ'  => 'Ê',
        'Ã‹'  => 'Ë', 'Å’'  => 'Œ', 'ÃŒ'  => 'Ì', 'Å½'  => 'Ž',
        'ÃŽ'  => 'Î', 'Ã‘'  => 'Ñ', 'Ã’'  => 'Ò', 'Ã“'  => 'Ó',
        'â€'  => '”', 'Ã”'  => 'Ô', 'Ã•'  => 'Õ', 'Ã–'  => 'Ö',
        'Ã—'  => '×', 'Ëœ'  => '˜', 'Ã˜'  => 'Ø', 'Ã™'  => 'Ù',
        'Å¡'  => 'š', 'Ãš'  => 'Ú', 'Ã›'  => 'Û', 'Å“'  => 'œ',
        'Ãœ'  => 'Ü', 'Å¾'  => 'ž', 'Ãž'  => 'Þ', 'Å¸'  => 'Ÿ',
        'ÃŸ'  => 'ß', 'Â¡'  => '¡', 'Ã¡'  => 'á', 'Â¢'  => '¢',
        'Ã¢'  => 'â', 'Â£'  => '£', 'Ã£'  => 'ã', 'Â¤'  => '¤',
        'Ã¤'  => 'ä', 'Â¥'  => '¥', 'Ã¥'  => 'å', 'Â¦'  => '¦',
        'Ã¦'  => 'æ', 'Â§'  => '§', 'Ã§'  => 'ç', 'Â¨'  => '¨',
        'Ã¨'  => 'è', 'Â©'  => '©', 'Ã©'  => 'é', 'Âª'  => 'ª',
        'Ãª'  => 'ê', 'Â«'  => '«', 'Ã«'  => 'ë', 'Â¬'  => '¬',
        'Ã¬'  => 'ì', 'Â®'  => '®', 'Ã®'  => 'î', 'Â¯'  => '¯',
        'Ã¯'  => 'ï', 'Â°'  => '°', 'Ã°'  => 'ð', 'Â±'  => '±',
        'Ã±'  => 'ñ', 'Â²'  => '²', 'Ã²'  => 'ò', 'Â³'  => '³',
        'Ã³'  => 'ó', 'Â´'  => '´', 'Ã´'  => 'ô', 'Âµ'  => 'µ',
        'Ãµ'  => 'õ', 'Â¶'  => '¶', 'Ã¶'  => 'ö', 'Â·'  => '·',
        'Ã·'  => '÷', 'Â¸'  => '¸', 'Ã¸'  => 'ø', 'Â¹'  => '¹',
        'Ã¹'  => 'ù', 'Âº'  => 'º', 'Ãº'  => 'ú', 'Â»'  => '»',
        'Ã»'  => 'û', 'Â¼'  => '¼', 'Ã¼'  => 'ü', 'Â½'  => '½',
        'Ã½'  => 'ý', 'Â¾'  => '¾', 'Ã¾'  => 'þ', 'Â¿'  => '¿',
        'Ã¿'  => 'ÿ', 'Ã€'  => 'À',

        // 1 char errors last
        'Ã' => 'Á', 'Å' => 'Š', 'Ã' => 'Í', 'Ã' => 'Ï',
        'Ã' => 'Ð', 'Ã' => 'Ý', 'Ã' => 'à', 'Ã­' => 'í',
        '�' => 'à'
    );

    $error_chars = array_keys($fix_list);
    $real_chars  = array_values($fix_list);

    return str_replace($error_chars, $real_chars, $inputString);
}
