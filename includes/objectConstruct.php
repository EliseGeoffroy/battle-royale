<?php

$perso1 = classChoice($pdo, 1);
$perso2 = classChoice($pdo, 2);


function weaponConstruct($idWeapon, $pdo)
{
    $statement = $pdo->prepare("SELECT name, strength, class FROM weapon WHERE id=:id");
    $statement->bindValue(':id', $idWeapon);
    $statement->execute();
    $arrayWeapon = $statement->fetch();
    $weapon = new Weapon($idWeapon, $arrayWeapon['name'], $arrayWeapon['strength'], $arrayWeapon['class']);
    return $weapon;
}

function classChoice($pdo, $numPerso)
{
    $statement = $pdo->prepare("SELECT idCharac, name, totalHealth, currHealth, currStrength, currDefense, esquiveBonus, class, idWeapon FROM currCharac WHERE numPerso=:numPerso ORDER BY idRound DESC");
    $statement->bindValue(':numPerso', $numPerso);
    $statement->execute();
    $arrayPerso = $statement->fetch();
    $weapon = weaponConstruct($arrayPerso['idWeapon'], $pdo);

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
