<?php

$dir = __DIR__;

require_once $dir . '/database/pdoOpen.php';

require_once $dir . '/includes/classPerso.php';
require_once $dir . '/includes/classWeapon.php';
require_once $dir . '/includes/usualFunctions.php';

require_once $dir . '/includes/objectConstruct.php';




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $action1 = $_POST['action1'];
    $action2 = $_POST['action2'];

    if ($action2 != 'attack') {
        if ($action2 == 'defende') {
            $perso2->defende();
        } else {
            $perso2->special();
        }
        switch ($action1) {
            case 'defende':
                $perso1->defende();

                break;

            case 'attack':
                $action1 = attack($perso1, $perso2);

                break;
            case 'special':
                $perso1->special();

                break;
        }
    } else {
        switch ($action1) {
            case 'defende':
                $perso1->defende();
                break;

            case 'attack':
                $action1 = attack($perso1, $perso2);
                break;

            case 'special':
                $perso1->special();
                break;
        }
        $action2 = attack($perso2, $perso1);
    }
}

echo 'je suis là!';
$statement = $pdo->prepare("INSERT INTO currcharac (idRound, numPerso, idCharac, name, currHealth, totalHealth, currStrength, currDefense, esquiveBonus, class, idWeapon, currStrengthWeapon, action) VALUES (DEFAULT,:numPerso,:id,:name,:currHealth,:totalHealth,:currStrength,:currDefense, :esquiveBonus, :class, :idWeapon, :currStrengthWeapon, :action)");

$statement->bindValue(':numPerso', 1);
$statement->bindValue(':id', $perso1->id);
$statement->bindValue(':name', $perso1->name);
$statement->bindValue(':currHealth', $perso1->health['currentPV']);
$statement->bindValue(':totalHealth', $perso1->health['totalPV']);
$statement->bindValue(':currStrength', $perso1->strength['basicStrength']);
$statement->bindValue(':currDefense', $perso1->defense['basicDefense']);
$statement->bindValue(':esquiveBonus', $perso1->esquiveBonus);
echo 'esquive :' . $perso1->esquiveBonus;
$statement->bindValue(':class', $perso1->class);
$statement->bindValue(':idWeapon', $perso1->weapon->id);
$statement->bindValue(':currStrengthWeapon', $perso1->weapon->strength);
$statement->bindValue(':action', $action1);

$statement->execute();


$statement->bindValue(':numPerso', 2);
$statement->bindValue(':id', $perso2->id);
$statement->bindValue(':name', $perso2->name);
$statement->bindValue(':currHealth', $perso2->health['currentPV']);
$statement->bindValue(':totalHealth', $perso2->health['totalPV']);
$statement->bindValue(':currStrength', $perso2->strength['basicStrength']);
$statement->bindValue(':currDefense', $perso2->defense['basicDefense']);
$statement->bindValue(':esquiveBonus', $perso2->esquiveBonus);
$statement->bindValue(':class', $perso2->class);
$statement->bindValue(':idWeapon', $perso2->weapon->id);
$statement->bindValue(':currStrengthWeapon', $perso2->weapon->strength);
$statement->bindValue(':action', $action2);

$statement->execute();



if (($perso1->health['currentPV'] <= 0) && ($perso2->health['currentPV'] <= 0)) {
    header('Location:./winner.php?win=0');
} else if ($perso2->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=1');
} else if ($perso1->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=2');
} else {
    header("Location:./game.php?status=gip");
}
