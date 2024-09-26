<?php

class Weapon
{
    function __construct(public $id, public $name, protected $strength, public $class) {}
    function __get($name)
    {
        return $this->$name;
    }
}
