<?php

class Nationality
{
    private $_nationName;

    public function __construct($nationName)
    {
        $this->_nationName = $nationName;
    }

    public function __toString()
    {
        return $this->_nationName;
    }

    public function getNationalityDeclaration($person)
    {
        return "{$person} is from {$this->_nationName}";
    }

    private static $_instances = array();

    public static function getInstance($name)
    {
        if (!isset(self::$_instances[$name])) {
            self::$_instances[$name] = new self($name);
        }
        return self::$_instances[$name];
    }
}

class User
{
    protected $_uid;
    protected $_nation;

    public function getUid()
    {
        return $this->_uid;
    }

    public function setUid($uid)
    {
        $this->_uid = $uid;
        return $this;
    }

    public function getNationality()
    {
        return $this->_nation;
    }

    public function setNationality($nation)
    {
        $this->_nation = $nation;
        return $this;
    }

    public function __toString()
    {
        return "User: #{$this->_uid}. " . $this->_nation->getNationalityDeclaration($this->_uid);
    }
}


$user = new User();
$user->setUid(714673)
     ->setNationality(Nationality::getInstance('Italia'));
echo $user, "\n";
// changing a Flyweight means referencing a new instance
// (which may actually already exist in the FlyweightFactory)
$user->setNationality(Nationality::getInstance('Australia'));
echo $user, "\n";