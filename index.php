<?php

require_once __DIR__ . '/config/env.php';

// Database Connection

$connection = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

// Set Default Timezone

date_default_timezone_set(DEFAULT_TIMEZONE);

// Start Session

session_start();

// Page Title

$title = "Starter Kit";

/* ===================================
# Functions
=================================== */

function get_output_buffer($file)
{
    ob_start();

    include_once $file;

    return ob_get_clean();
}

function set_title($new_title)
{
    global $title;

    $title = $new_title;
}

/* ===================================
# /Functions
=================================== */

$url = $_GET["url"] ?? false;

$template = get_output_buffer(__DIR__ . '/template.php');

$children = get_output_buffer(__DIR__ . '/views/home.php');

if ($url) {
    if (file_exists(__DIR__ . '/views/' . $url . '.php')) {
    } else {
        $children = get_output_buffer(__DIR__ . '/views/404.php');
    }
}

$view = str_replace("{{ title }}", $title, $template);
$view = str_replace("{{ children }}", $children, $view);

echo $view;
