<?php

class Singleton {
    public static $instance;

    public static function getInstance()
    {
        if(!self::$instance instanceof self){
            self::$instance = new self();
        }

        return  self::$instance;
    }
}

$cl = Singleton::getInstance();
