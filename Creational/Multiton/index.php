<?php

abstract class FactoryAbstract
{
    protected static $instances = [];

    public static function getInstance()
    {
        $class = static::getClassName();
        if(!self::$instances[$class] instanceof $class){
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }

    final protected static function getClassName()
    {
        return get_called_class();
    }
}

abstract class Factory extends FactoryAbstract
{
    final public static function getInstance()
    {
        return parent::getInstance();
    }
}

class FirstProduct extends Factory
{
    public $a = [];
}

class SecondProduct extends FirstProduct
{
}

FirstProduct::getInstance()->a[] = 1;
SecondProduct::getInstance()->a[] = 2;
FirstProduct::getInstance()->a[] = 3;
SecondProduct::getInstance()->a[] = 4;

print_r(FirstProduct::getInstance()->a);
// array(1, 3)
print_r(SecondProduct::getInstance()->a);
// array(2, 4)