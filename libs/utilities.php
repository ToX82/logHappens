<?php

/**
 * Transforms the date into a localized readable format.
 *
 * @param string $date Date in string format.
 * @param bool $localized If true, the date will be localized.
 * @return string Localized date string or formatted date string.
 */
function toDateTime($date, $localized = false)
{
    if ($date === '0000-00-00') {
        return '-';
    }

    $formattedDate = date('Y-m-d H:i:s', strtotime($date));

    if (!$localized) {
        return $formattedDate;
    }

    $lang = getFullBrowserLanguage();

    $lang = explode(',', $lang)[0];
    if (strlen($lang) == 2) {
        $lang = $lang . '_' . strtoupper($lang);
    }

    \Moment\Moment::setLocale($lang);
    $moment = new \Moment\Moment($formattedDate);

    return $moment->format('LLLL:s', new \Moment\CustomFormats\MomentJs());
}

/**
 * Time tracker.
 *
 * @return float|bool Time in seconds since last call or true on first call.
 */
function benchmark()
{
    static $start = null;

    if (is_null($start)) {
        $start = microtime(true);
        return true;
    }

    $benchmark = round(microtime(true) - $start, 2);
    $start = microtime(true);

    return $benchmark;
}

/**
 * Convert memory size to a human readable format.
 *
 * @param int $size Size in bytes.
 * @return string Human readable size.
 */
function convert($size)
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
    $index = floor(log($size, 1024));

    return round($size / pow(1024, $index), 2) . ' ' . $unit[$index];
}

/**
 * List settings based on parameter.
 *
 * @param string $parameter Which parameter to retrieve.
 * @return mixed Settings data.
 */
function listSettings($parameter)
{
    $data = [
        'theme' => [
            'default' => 'bootstrap',
            'options' => [
                'bootstrap', 'cerulean', 'cosmo', 'cyborg', 'darkly', 'flatly',
                'journal', 'litera', 'lumen', 'lux', 'materia', 'minty', 'morph',
                'pulse', 'quartz', 'sandstone', 'simplex', 'sketchy', 'slate',
                'solar', 'spacelab', 'superhero', 'united', 'vapor', 'yeti',
                'zephyr'
            ],
        ],
        'refresh' => [
            'default' => 5,
            'options' => ['5', '15', '30', '60', '120'],
        ],
        'page-length' => [
            'default' => 10,
            'options' => ['10', '25', '50', '100'],
        ],
    ];

    return $data[$parameter] ?? null;
}

/**
 * Get the user-selected theme.
 *
 * @param string $parameter Which parameter to retrieve.
 * @return mixed Selected value.
 */
function setting($parameter)
{
    if (isset($_COOKIE[$parameter])) {
        return $_COOKIE[$parameter];
    }

    $settings = listSettings($parameter);
    $selected = $settings['default'] ?? null;

    return writeSettingsCookie($parameter, $selected);
}

/**
 * Writes the user's selected value into a cookie.
 *
 * @param string $parameter Parameter's name.
 * @param string $selected Selected value.
 * @return string Selected value.
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
 * Opens a file or terminates execution if the file cannot be opened.
 *
 * @param string $file Path to the file.
 * @return array|false File contents or an error message.
 */
function openFileOrDie($file)
{
    if (is_file($file)) {
        try {
            return file($file);
        } catch (Exception $e) {
            die('Unable to open file: ' . $file . '!');
        }
    }

    return ['Unable to open file: ' . $file . '!'];
}

/**
 * Select a random 404 error haiku.
 *
 * @return string Random haiku.
 */
function randomError()
{
    $haikus = [
        "A page like that?<br>It might be very useful.<br>But now it is gone.",
        "This page is not here,<br>The error message spoke clear,<br>Where could it have gone?",
        "Program aborting:<br>Close all that you have worked on.<br>You ask far too much.",
        "Yesterday it worked.<br>Today it is not working.<br>Servers are like that.",
        "A page once existed,<br>But now it's gone, just like that,<br>The internet's cruel.",
        "You step in the stream,<br>But the water has moved on.<br>This page is not here.",
        "The page you seek is lost,<br>Like socks in the dryer's frost,<br>Please try once again.",
        "Serious error.<br>All shortcuts have disappeared.<br>Screen. Mind. Both are blank.",
        "Something you entered<br>transcended parameters.<br>So much is unknown.",
        "Not a pretty sight<br>When the web dies screaming loud<br>The page is not found.",
        "Errors have occurred.<br>We won't tell you where or why.<br>Lazy programmers.",
        "Code path vanished,<br>404 error in sight,<br>Debugging my night.",
        "Algorithmic dance,<br>404 error interrupts,<br>Bug-fix waltz begins.",
    ];

    return $haikus[array_rand($haikus)];
}

/**
 * Select a random haiku for when no errors are found.
 *
 * @return string Random haiku.
 */
function randomHappyness()
{
    $haikus = [
        "No error logs found,<br>Troubleshooting is a maze,<br>Where did the bug hide?",
        "The code runs just fine,<br>And the logs are empty still,<br>No errors to find.",
        "In the land of code,<br>Where magic meets technology,<br>No error logs were found.",
    ];

    return $haikus[array_rand($haikus)];
}

/**
 * Normalize characters in an input string.
 *
 * @param string $inputString Input string.
 * @return string Normalized string.
 */
function normalizeChars($inputString)
{
    $fixList = [
        'â€š' => '‚', 'â€ž' => '„', 'â€¦' => '…', 'â€¡' => '‡', 'â€°' => '‰', 'â€¹' => '‹',
        'â€˜' => '‘', 'â€™' => '’', 'â€œ' => '“', 'â€¢' => '•', 'â€“' => '–', 'â€”' => '—',
        'â„¢' => '™', 'â€º' => '›', 'â‚¬' => '€', 'Ã‚' => 'Â', 'Æ’' => 'ƒ', 'Ãƒ' => 'Ã',
        'Ã„' => 'Ä', 'Ã…' => 'Å', 'â€' => '†', 'Ã†' => 'Æ', 'Ã‡' => 'Ç', 'Ë†' => 'ˆ',
        'Ãˆ' => 'È', 'Ã‰' => 'É', 'ÃŠ' => 'Ê', 'Ã‹' => 'Ë', 'Å’' => 'Œ', 'ÃŒ' => 'Ì',
        'Å½' => 'Ž', 'ÃŽ' => 'Î', 'Ã‘' => 'Ñ', 'Ã’' => 'Ò', 'Ã“' => 'Ó', 'Ã”' => 'Ô',
        'Ã•' => 'Õ', 'Ã–' => 'Ö', 'Ã€' => 'À', 'Ã—' => '×', 'Ëœ' => '˜', 'Ã˜' => 'Ø',
        'Ã™' => 'Ù', 'Å¡' => 'š', 'Ãš' => 'Ú', 'Ã›' => 'Û', 'Å“' => 'œ', 'Ãœ' => 'Ü',
        'Å¾' => 'ž', 'Ãž' => 'Þ', 'Å¸' => 'Ÿ', 'ÃŸ' => 'ß', 'Â¡' => '¡', 'Ã¡' => 'á',
        'Â¢' => '¢', 'Ã¢' => 'â', 'Â£' => '£', 'Ã£' => 'ã', 'Â¤' => '¤', 'Ã¤' => 'ä',
        'Â¥' => '¥', 'Ã¥' => 'å', 'Â¦' => '¦', 'Ã¦' => 'æ', 'Â§' => '§', 'Ã§' => 'ç',
        'Â¨' => '¨', 'Ã¨' => 'è', 'Â©' => '©', 'Ã©' => 'é', 'Âª' => 'ª', 'Ãª' => 'ê',
        'Â«' => '«', 'Ã«' => 'ë', 'Â¬' => '¬', 'Ã¬' => 'ì', 'Â®' => '®', 'Ã®' => 'î',
        'Â¯' => '¯', 'Ã¯' => 'ï', 'Â°' => '°', 'Ã°' => 'ð', 'Â±' => '±', 'Ã±' => 'ñ',
        'Â²' => '²', 'Ã²' => 'ò', 'Â³' => '³', 'Ã³' => 'ó', 'Â´' => '´', 'Ã´' => 'ô',
        'Âµ' => 'µ', 'Ãµ' => 'õ', 'Â¶' => '¶', 'Ã¶' => 'ö', 'Â·' => '·', 'Ã·' => '÷',
        'Â¸' => '¸', 'Ã¸' => 'ø', 'Â¹' => '¹', 'Ã¹' => 'ù', 'Âº' => 'º', 'Ãº' => 'ú',
        'Â»' => '»', 'Ã»' => 'û', 'Â¼' => '¼', 'Ã¼' => 'ü', 'Â½' => '½', 'Ã½' => 'ý',
        'Â¾' => '¾', 'Ã¾' => 'þ', 'Â¿' => '¿', 'Ã¿' => 'ÿ', 'Ã' => 'Á', 'Å' => 'Š',
        'Ã­' => 'í', '�' => 'à'
    ];

    return str_replace(array_keys($fixList), array_values($fixList), $inputString);
}
