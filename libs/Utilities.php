<?php

declare(strict_types=1);

namespace Libs;

use Moment\CustomFormats\MomentJs;
use Moment\Moment;

/**
 * General utilities and app-level helpers.
 */
class Utilities
{
    /**
     * Transforms the date into a localized readable format.
     *
     * @param string $date
     * @param bool $localized
     * @return string
     */
    public static function toDateTime(string $date, bool $localized = false): string
    {
        if ($date === '0000-00-00') {
            return '-';
        }

        $formattedDate = date('Y-m-d H:i:s', strtotime($date));

        if (!$localized) {
            return $formattedDate;
        }

        $lang = (new LanguageDetector())->getFullBrowserLanguage();
        $lang = explode(',', $lang)[0];
        if (strlen($lang) === 2) {
            $lang = $lang . '_' . strtoupper($lang);
        }

        Moment::setLocale($lang);
        $moment = new Moment($formattedDate);

        return $moment->format('LLLL:s', new MomentJs());
    }

    /**
     * Time tracker.
     *
     * @return float|bool
     */
    public static function benchmark(): float|bool
    {
        static $start = null;

        if ($start === null) {
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
     * @param int $size
     * @return string
     */
    public static function convert(int $size): string
    {
        if ($size <= 0) {
            return '0 b';
        }

        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        $index = (int)floor(log($size, 1024));
        $index = max(0, min($index, count($unit) - 1));

        return round($size / pow(1024, $index), 2) . ' ' . $unit[$index];
    }

    /**
     * List settings based on parameter.
     *
     * @param string $parameter
     * @return array|null
     */
    public static function listSettings(string $parameter): ?array
    {
        $data = [
            'theme' => [
                'default' => 'bootstrap',
                'options' => [
                    'bootstrap', 'brite', 'cerulean', 'cosmo', 'cyborg', 'darkly', 'flatly',
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
     * @param string $parameter
     * @return string
     */
    public static function setting(string $parameter): string
    {
        if (isset($_COOKIE[$parameter])) {
            return (string)$_COOKIE[$parameter];
        }

        $settings = self::listSettings($parameter);
        $selected = (string)($settings['default'] ?? '');

        return self::writeSettingsCookie($parameter, $selected);
    }

    /**
     * Writes the user's selected value into a cookie.
     *
     * @param string $parameter
     * @param string $selected
     * @return string
     */
    public static function writeSettingsCookie(string $parameter, string $selected): string
    {
        $settings = self::listSettings($parameter);

        if (!in_array($selected, $settings['options'] ?? [], true)) {
            $selected = (string)($settings['default'] ?? '');
        }

        // Avoid header warnings during CLI runs
        if (PHP_SAPI !== 'cli') {
            setcookie($parameter, $selected, strtotime('+1 year'), '/');
        }

        return $selected;
    }

    /**
     * Opens a file or terminates execution if the file cannot be opened.
     *
     * @param string $file
     * @return array
     */
    public static function openFileOrDie(string $file): array
    {
        if (is_file($file)) {
            try {
                return file($file);
            } catch (\Exception $e) {
                die('Unable to open file: ' . $file . '!');
            }
        }

        return ['Unable to open file: ' . $file . '!'];
    }

    /**
     * Select a random 404 error haiku.
     *
     * @return string
     */
    public static function randomError(): string
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
     * Normalize characters in an input string.
     *
     * @param string $inputString
     * @return string
     */
    public static function normalizeChars(string $inputString): string
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
}
