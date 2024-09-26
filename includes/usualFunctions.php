<?php

function weaponChoice($idWeapon, $numPerso, $pdo)
{
    $statement = $pdo->prepare("SELECT strength FROM weapon WHERE id=:id");
    $statement->bindValue(':id', $idWeapon);
    $statement->execute();
    $weaponStrength = $statement->fetch()['strength'];


    $statement = $pdo->prepare("UPDATE currcharac SET idWeapon=:id, currStrengthWeapon=:strengthWeapon WHERE numPerso=:numPerso");
    $statement->bindValue(':id', $idWeapon);
    $statement->bindValue(':strengthWeapon', $weaponStrength);
    $statement->bindValue(':numPerso', $numPerso);
    $statement->execute();
}

function characChoice($id, $numPerso, $pdo)
{

    $statement = $pdo->prepare("SELECT id, name, strength, defense, health, class FROM characterlist WHERE id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $charac = $statement->fetch();


    $statement = $pdo->prepare("INSERT INTO currcharac (idRound, numPerso, idCharac, name, currHealth, totalHealth, currStrength, currDefense, esquiveBonus, class) VALUES (DEFAULT,:numPerso,:id,:name,:currHealth,:totalHealth,:currStrength,:currDefense, false, :class)");

    $statement->bindValue(':numPerso', $numPerso);
    $statement->bindValue(':id', $_GET['id']);
    $statement->bindValue(':name', $charac['name']);
    $statement->bindValue(':currHealth', $charac['health']);
    $statement->bindValue(':totalHealth', $charac['health']);
    $statement->bindValue(':currStrength', $charac['strength']);
    $statement->bindValue(':currDefense', $charac['defense']);
    $statement->bindValue(':class', $charac['class']);

    $statement->execute();

    $statement = $pdo->prepare("UPDATE characterList SET status='taken' WHERE id=:id");
    $statement->bindValue(':id', $_GET['id']);
    $statement->execute();
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

function editDescription($pdo, $activPerso, $passivPerso, $numPerso)
{

    $statement = $pdo->prepare("SELECT action FROM currCharac WHERE numPerso=:numPerso ORDER BY idRound DESC");
    $statement->bindValue(':numPerso', $numPerso);
    $statement->execute();
    $action = $statement->fetch()['action'];
    echo 'action' . $action;


    if ($action == 'defende') {
        $descrAction = $activPerso->name . ' se met en position de défense.';
    } else if ($action == 'special') {
        $descrAction = $activPerso->name . ' a utilisé son action spéciale : ' . $activPerso->specialAction;
    } else if (preg_match('/^attack/', $action)) {
        $actionTable = explode('-', $action);
        echo $action;
        print_r($actionTable);
        if ($actionTable['1'] == 0) {
            $descrAction = $activPerso->name . ' a essayé d\'attaquer ' . $passivPerso->name . ' mais ce dernier a esquivé.';
        } else {
            $descrAction = $activPerso->name . ' a attaqué ' . $passivPerso->name . ' et lui a enlevé ' . $actionTable[1] . ' de dégâts.';
        }
    }

    return $descrAction;
}
