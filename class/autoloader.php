<?php

namespace ablin42;

class autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class_name)
    {
        if (strpos($class_name, __NAMESPACE__ . '\\') == 0)
        {
            $class_name = str_replace(__NAMESPACE__ . '\\', '', $class_name);
            require "{$class_name}.php";
        }
    }
}