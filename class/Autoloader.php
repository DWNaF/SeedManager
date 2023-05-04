<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class_name) {
            $class_name = str_replace('\\', '/', $class_name);
            require_once $class_name . '.php';
        });
    }
}
