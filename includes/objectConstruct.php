<?php

function weaponConstruct($idWeapon, $weaponDB)
{
    $arrayWeapon = $weaponDB->selectOne($idWeapon);
    $weapon = new Weapon($idWeapon, $arrayWeapon['name'], $arrayWeapon['strength'], $arrayWeapon['class']);

    return $weapon;
}

function classChoice($currCharacDB, $numPerso, $weaponDB)
{
    $arrayPerso = $currCharacDB->selectOne($numPerso);


    $weapon = weaponConstruct($arrayPerso['idWeapon'], $weaponDB);

    switch ($arrayPerso['class']) {
        case 'elf':
            $perso = new Elf($arrayPerso['idCharac'], $arrayPerso['name'], $arrayPerso['totalHealth'], $arrayPerso['currHealth'], $arrayPerso['currStrength'], $arrayPerso['currDefense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
        case 'dwarf':
            $perso = new Dwarf($arrayPerso['idCharac'], $arrayPerso['name'], $arrayPerso['totalHealth'], $arrayPerso['currHealth'], $arrayPerso['currStrength'], $arrayPerso['currDefense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
        case 'man':
            $perso = new Man($arrayPerso['idCharac'], $arrayPerso['name'], $arrayPerso['totalHealth'], $arrayPerso['currHealth'], $arrayPerso['currStrength'], $arrayPerso['currDefense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
    }

    return $perso;
}
