<?php

interface PersoModel
{
    function attack(int $defense, bool $esquiveBonus);
    function defende();
    function beAttacked(int $damage);
    function endOfGame();
    //  function special();
}

trait BaseAction
{
    function attack(int $defense, bool $esquiveBonus)
    {
        if ($esquiveBonus == true) {
            $succeed = random_int(1, 6) > 4 ? true : false;
        } else {
            $succeed = random_int(1, 6) > 2 ? true : false;
        }
        if ($succeed) {
            $damage = ($this->strength['currentStrength'] - $defense > 0) ? $this->strength['currentStrength'] - $defense : 0;
        } else {
            $damage = null;
        }
        return $damage;
    }

    function defende()
    {
        $this->defense['currentDefense'] *= 2;
    }
}

trait BaseEvent
{
    function beAttacked(int $damage)
    {
        $this->health['currentPV'] -= $damage;
    }

    function endOfGame()
    {
        $this->defense['currentDefense'] = $this->defense['basicDefense'];
    }
}

class Perso implements PersoModel

{
    protected array $health;
    protected array $defense;
    protected array $strength;

    use BaseAction;
    use BaseEvent;

    function __set($name, $value)
    {

        switch ($name) {
            case 'currentPV':
                $this->health['currentPV'] = $value;
                break;
            case 'totalPV':
                $this->health['totalPV'] = $value;
                break;
            case 'currentStrength':
                $this->strength['currentStrength'] = $value;
                break;
            case 'basicStrength':
                $this->strength['basicStrength'] = $value;
                break;
            case 'currentDefense':
                $this->defense['currentDefense'] = $value;
                break;
            case 'basicDefense':
                $this->defense['basicDefense'] = $value;
                break;
            default:
                $this->$name = $value;
                break;
        }
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __construct(public $id, public $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, protected $esquiveBonus)
    {
        $this->health = [
            'currentPV' => $currentPV,
            'totalPV' => $totalPV
        ];

        $this->defense = [
            'currentDefense' => $basicDefense,
            'basicDefense' => $basicDefense
        ];


        $this->strength = [
            'currentStrength' => $basicStrength,
            'basicStrength' => $basicStrength
        ];
    }

    function __toString()
    {
        $currentPV = $this->health['currentPV'];
        $totalPV = $this->health['totalPV'];
        $currentStrength = $this->strength['currentStrength'];
        $currentDefense = $this->defense['currentDefense'];
        $weaponName = $this->weapon->name;

        return "$this->name armé de $weaponName PV: $currentPV/$totalPV Att:$currentStrength Def:$currentDefense";
    }

    function toJson()
    {
        $arrayPerso = [
            'id' => $this->id,
            'name' => $this->name,
            'health' => $this->health,
            'strength' => $this->strength['currentStrength'],
            'defense' => $this->defense['basicDefense'],
            'esquiveBonus' => $this->esquiveBonus,
            'weapon' => $this->weapon->toJson()
        ];
        return $arrayPerso;
    }
}

class Man extends Perso
{

    public $specialAction = 'Se vanter';

    public function special()
    {
        $this->strength['currentStrength'] = ceil($this->strength['currentStrength'] * 120 / 100);
        $this->defense['basicDefense'] = floor($this->defense['basicDefense'] * 80 / 100);
    }

    function toJson()
    {
        $arrayPerso = parent::toJson();
        $arrayPerso = [...$arrayPerso, 'class' => 'Man'];
        return $arrayPerso;
    }

    function __construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus, protected $weapon)
    {
        parent::__construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus);

        $armedStrength = ($weapon->class == 'sword') ? ceil($basicStrength + $weapon->strength * 120 / 100) : $basicStrength + $weapon->strength;
        $this->strength['currentStrength'] = $armedStrength;
    }
}

class Dwarf extends Perso
{

    public $specialAction = 'Boire';

    public function special()
    {
        $newPV = ceil($this->health['currentPV'] + $this->health['totalPV'] * 30 / 100);
        $this->health['currentPV'] = ($newPV < $this->health['totalPV']) ? $newPV : $this->health['totalPV'];

        $this->defense['currentDefense'] = ceil($this->defense['currentDefense'] * 50 / 100);
    }

    function toJson()
    {
        $arrayPerso = parent::toJson();
        $arrayPerso = [...$arrayPerso, 'class' => 'Dwarf'];
        return $arrayPerso;
    }

    function __construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus, protected $weapon)
    {
        parent::__construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus);

        $armedStrength = ($weapon->class == 'ax') ? ceil($basicStrength + $weapon->strength * 120 / 100) : $basicStrength + $weapon->strength;
        $this->strength['currentStrength'] = $armedStrength;
    }
}

class Elf extends Perso
{
    public $specialAction = 'Esquiver';
    function special()
    {
        $this->esquiveBonus = true;
    }

    function toJson()
    {
        $arrayPerso = parent::toJson();
        $arrayPerso = [...$arrayPerso, 'class' => 'Elf', "esquiveBonus" => $this->esquiveBonus];
        return $arrayPerso;
    }


    function __construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus, protected $weapon)
    {
        parent::__construct($id, $name, $totalPV, $currentPV,  $basicStrength, $basicDefense, $esquiveBonus);

        $armedStrength = ($weapon->class == 'bow') ? ceil($basicStrength + $weapon->strength * 120 / 100) : $basicStrength + $weapon->strength;
        $this->strength['currentStrength'] = $armedStrength;
    }
}