<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

require_once ROOT_PATH . 'class/Autoloader.php';
Autoloader::register();

if (!defined('DATA_PATH')) {
    define('DATA_PATH', ROOT_PATH . 'data' . DIRECTORY_SEPARATOR);
}

if (!defined('REL_PATH')) {
    define('REL_PATH', DIRECTORY_SEPARATOR . basename(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);
}

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', REL_PATH . 'public' . DIRECTORY_SEPARATOR);
}

if (!defined('CSS_PATH')) {
    define('CSS_PATH', REL_PATH . 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR);
}

if (!defined('CSS_PATH_FULL')) {
    define('CSS_PATH_FULL', ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR);
}

if (!defined('JS_PATH')) {
    define('JS_PATH', REL_PATH . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR);
}

if (!defined('JS_PATH_INCL')) {
    define('JS_PATH_INCL', ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR);
}

if (!defined('INCLUDES_PATH')) {
    define('INCLUDES_PATH', ROOT_PATH . 'includes' . DIRECTORY_SEPARATOR);
}

if (!defined('HANDLERS_PATH')) {
    define('HANDLERS_PATH', PUBLIC_PATH . 'handlers' . DIRECTORY_SEPARATOR);
}

if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', CSS_PATH . 'assets' . DIRECTORY_SEPARATOR);
}

if (!defined('SEEDS_ASSETS_PATH')) {
    define('SEEDS_ASSETS_PATH', ASSETS_PATH . 'seeds' . DIRECTORY_SEPARATOR);
}

if (!defined('SEEDS_ASSETS_PATH_FULL')) {
    define('SEEDS_ASSETS_PATH_FULL', ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR);
}

if (!defined('LOGOS_ASSETS_PATH')) {
    define('LOGOS_ASSETS_PATH', ASSETS_PATH . 'logos' . DIRECTORY_SEPARATOR);
}
