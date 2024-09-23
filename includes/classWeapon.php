<?php

class Weapon
{
    function __construct(public $name, protected $strength, public $class) {}
    function __get($name)
    {
        return $this->$name;
    }

    function toJson()
    {
        $arrayWeapon = [
            'name' => $this->name,
            'strength' => $this->strength,
            'class' => $this->class
        ];
        return $arrayWeapon;
    }
}
