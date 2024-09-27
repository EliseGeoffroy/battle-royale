<?php

function weaponChoice($idWeapon, $numPerso, $currCharacDB, $weaponDB)
{
    $strengthWeapon = $weaponDB->selectStrength($idWeapon)['strength'];

    $currCharacDB->updateWeapon($idWeapon, $strengthWeapon, $numPerso);
}

function characChoice($id, $numPerso, $characterListDB, $currCharacDB)
{

    $charac = $characterListDB->selectById($id);


    $currCharacDB->insertCharac($numPerso, $_GET['id'], $charac['name'], $charac['health'], $charac['health'], $charac['strength'], $charac['defense'], 0, $charac['class']);

    $characterListDB->updateStatus('taken', $_GET['id']);
}



function attack($persoAtt, $persoDef)
{
    $damage = $persoAtt->attack($persoDef->defense['currentDefense'], $persoDef->esquiveBonus);
    $persoDef->esquiveBonus = false;
    if ($damage) {
        $persoDef->beAttacked($damage);
        $action = 'attack-' . $damage;
    } else {
        $action = 'attack-0';
    }
    return $action;
}

function editDescription($activPerso, $passivPerso, $numPerso, $currCharacDB)
{

    $action = $currCharacDB->selectOneAction($numPerso)['action'];


    if ($action == 'defende') {
        $descrAction = $activPerso->name . ' se met en position de défense.';
    } else if ($action == 'special') {
        $descrAction = $activPerso->name . ' a utilisé son action spéciale : ' . $activPerso->specialAction;
    } else if (preg_match('/^attack/', $action)) {
        $actionTable = explode('-', $action);
        if ($actionTable['1'] == 0) {
            $descrAction = $activPerso->name . ' a essayé d\'attaquer ' . $passivPerso->name . ' mais ce dernier a esquivé.';
        } else {
            $descrAction = $activPerso->name . ' a attaqué ' . $passivPerso->name . ' et lui a enlevé ' . $actionTable[1] . ' de dégâts.';
        }
    }

    return $descrAction;
}
