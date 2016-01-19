<?php

class Registry {
    public static $data = [];

    public static function get($key)
    {
        return isset(self::$data[$key])? self::$data[$key] : null;
    }

    public static function set($key, $val)
    {
        self::$data[$key] = $val;
    }
}

Registry::set('t', 'aaaa');
var_dump(Registry::get('t'));