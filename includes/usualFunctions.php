<?php

function classChoice($arrayPerso)
{
    $arrayWeapon = $arrayPerso['weapon'];
    $weapon = new Weapon($arrayWeapon['name'], $arrayWeapon['strength'], $arrayWeapon['class']);

    switch ($arrayPerso['class']) {
        case 'Elf':
            $perso = new Elf($arrayPerso['id'], $arrayPerso['name'], $arrayPerso['health']['totalPV'], $arrayPerso['health']['currentPV'], $arrayPerso['strength'], $arrayPerso['defense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
        case 'Dwarf':
            $perso = new Dwarf($arrayPerso['id'], $arrayPerso['name'], $arrayPerso['health']['totalPV'], $arrayPerso['health']['currentPV'], $arrayPerso['strength'], $arrayPerso['defense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
        case 'Man':
            $perso = new Man($arrayPerso['id'], $arrayPerso['name'], $arrayPerso['health']['totalPV'], $arrayPerso['health']['currentPV'], $arrayPerso['strength'], $arrayPerso['defense'], $arrayPerso['esquiveBonus'], $weapon);
            break;
    }

    return $perso;
}

function attack($persoAtt, $persoDef)
{
    $damage = $persoAtt->attack($persoDef->defense['currentDefense'], $persoDef->esquiveBonus);
    $persoDef->esquiveBonus = false;
    if ($damage) {
        $persoDef->beAttacked($damage);

        $descrAction = $persoAtt->name . ' a attaqué ' . $persoDef->name . ' et lui a enlevé ' . $damage . ' de dégâts.';
    } else {
        $descrAction = $persoAtt->name . ' a essayé d\'attaquer ' . $persoDef->name . ' mais ce dernier a esquivé.';
    }
    return $descrAction;
}
