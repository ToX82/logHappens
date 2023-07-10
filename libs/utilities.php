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

    $date = date('Y-m-d H:i:s', strtotime($date));
    $lang = getFullBrowserLanguage();

    if (strpos($lang, ",") !== false) {
        $lang = substr($lang, 0, strpos($lang, ","));
    }

    if (strlen($lang) == 2) {
        $lang = substr($lang, 0, 2) . '_' . strtoupper(substr($lang, 0, 2));
    }

    \Moment\Moment::setLocale($lang);
    $m = new \Moment\Moment($date);

    return $m->format('LLLL:s', new \Moment\CustomFormats\MomentJs());
}

/**
 * Time tracker
 *
 * @return float|bool
 */
function benchmark()
{
    static $start = null;

    if (is_null($start)) {
        $start = getmicrotime();

        return true;
    } else {
        $benchmark = getmicrotime() - $start;
        $start = getmicrotime();

        return round($benchmark, 2);
    }
}

/**
 * Get timestamp
 *
 * @return float
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
 * @return string
 */
function convert($size)
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * List settings
 *
 * @param string $parameter Which parameters we need
 * @return mixed
 */
function listSettings($parameter)
{
    $data = [
        'theme' => [
            'default' => 'bootstrap',
            'options' => [
                'bootstrap',
                'cerulean',
                'cosmo',
                'cyborg',
                'darkly',
                'flatly',
                'journal',
                'litera',
                'lumen',
                'lux',
                'materia',
                'minty',
                'morph',
                'pulse',
                'quartz',
                'sandstone',
                'simplex',
                'sketchy',
                'slate',
                'solar',
                'spacelab',
                'superhero',
                'united',
                'vapor',
                'yeti',
                'zephyr',
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
 * @param string $parameter Which parameters we need
 * @return mixed
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
 * Writes the user's selected value into a cookie
 *
 * @param string $parameter parameter's name
 * @param string $selected selected value
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
 * Select a random 404 error
 *
 * @return string
 */
function randomError()
{
    $haiku = [
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
    ];

    return $haiku[array_rand($haiku)];
}

/**
 * Normalize characters in an input string
 *
 * @param string $inputString Input string
 * @return string
 */
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
        'Ã”'  => 'Ô', 'Ã•'  => 'Õ', 'Ã–'  => 'Ö', 'Ã€'  => 'À',
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
        'Ã¿'  => 'ÿ',

        // 1 char errors last
        'Ã' => 'Á', 'Å' => 'Š', 'Ã­' => 'í', '�' => 'à'
    );

    $error_chars = array_keys($fix_list);
    $real_chars  = array_values($fix_list);

    return str_replace($error_chars, $real_chars, $inputString);
}


function listConfigurations($parameter)
{
    $data = [
        'theme' => [
            'default' => 'bootstrap',
            'options' => [
                'bootstrap',
                'cerulean',
                'cosmo',
                'cyborg',
                'darkly',
                'flatly',
                'journal',
                'litera',
                'lumen',
                'lux',
                'materia',
                'minty',
                'morph',
                'pulse',
                'quartz',
                'sandstone',
                'simplex',
                'sketchy',
                'slate',
                'solar',
                'spacelab',
                'superhero',
                'united',
                'vapor',
                'yeti',
                'zephyr',
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
 * @param string $parameter Which parameters we need
 * @return mixed
 */
function configuration($parameter)
{
    if (isset($_POST[$parameter])) {
        $selected = $_COOKIE[$parameter];
    } else {
        $settings = listConfigurations($parameter);
        $selected = $settings['default'];
        //$selected = writeSettingsCookie($parameter, $selected);
    }

    return $selected;
}

function getConfigurations($filepath) {
    $jsonString = file_get_contents($filepath);
    $data = json_decode($jsonString);

    return $data->parsers;
}

function displayConfigurations($configurations) {
    
    $modify = false;

    echo '<div class="card-body d-flex flex-column">';
    foreach ($configurations as $config => $value) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['btn-modify_'.$config])) {
                $modify = true;
            }
            else {
                $modify = false;
            }
                
        }

        echo 
        '<div class="card mb-3">'.
            '<form method="post" class="card-header d-flex justify-content-between align-items-center">
                <label for="config">'.$config.'</label>';
                echo $modify ? '<input type="submit" value="Save" name="btn-save_'.$config.'" class="btn btn-success btn-sm">'
                : '<input type="submit" value="Modify" name="btn-modify_'.$config.'" class="btn btn-primary btn-sm">';
            echo '</form>';
        displayOptions($value, $modify);
        echo '</div>';
    }
    echo '</div>';
}
function displayOptions($config, $modify) {
    if($modify) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "ciao";
            $input_icon = $_POST["input-icon"];
            echo $input_icon;
        }
    }
    
    echo '<form method="post" class="mt-3 d-flex flex-column">'.
            '<div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">'.
                '<h6><label for="icon" class="form-label">Icon</label></h6>
                <input class="" type="text" id="input-icon" name="input-icon" ';
                echo $modify ? '' : ' hidden ';
                echo ' value="'.$config->icon.'"/>';
                if(!$modify) echo $config->icon;
                    
                    
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="color" class="form-label">Color</label></h6>
                    <input '; echo $modify ? '' : ' disabled readonly '; echo 'type="color" class="form-control form-control-color" id="input-color" name="input-color" value="'.$config->color.'">
                    </div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="title" class="form-label">Title</label></h6>';
                echo $modify ?
                    '<input type="text" class="form-control" id="input-title" name="input-title" value="'.$config->title.'"/>'
                    : $config->title;
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="file" class="form-label">File</label></h6>';
                echo $modify ?
                    '<input type="text" class="form-control" id="input-file" name="input-file" value="'.$config->file.'"/>'
                    : $config->file;
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="parser" class="form-label">Parser</label></h6>';
                echo $modify ?
                    '<input type="text" class="form-control" id="input-parser" name="input-parser" value="'.$config->parser.'"/>'
                    : $config->parser;
                echo '</div>'.

            '<div class="ms-2 d-flex flex-column mb-3 align-items-start">'.
                '<h6><label for="state" class="form-label">State</label></h6>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled" role="switch"';
                    if(!$config->disabled) {
                        echo 'checked';
                    }
                    echo '>
                </div>
            </div>'.
            '</form>';
}

