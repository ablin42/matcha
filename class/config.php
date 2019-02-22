<?php

namespace ablin42;

class config
{
    private $settings = [];
    private static $_instance;

    private function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/config/config.php';
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new config();
        return self::$_instance;
    }

    public function get($key)
    {
        if (!isset($this->settings[$key]))
            return null;
        return $this->settings[$key];
    }

}