<?php

$dir = __DIR__;


$currCharacDB = require_once($dir . '/database/models/currCharacDB.php');
$weaponDB = require_once($dir . '/database/models/weaponDB.php');


require_once $dir . '/includes/classPerso.php';
require_once $dir . '/includes/classWeapon.php';


require_once $dir . '/includes/usualFunctions.php';

require_once $dir . '/includes/objectConstruct.php';
$perso1 = classChoice($currCharacDB, 1, $weaponDB);
$perso2 = classChoice($currCharacDB, 2, $weaponDB);



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
echo '<pre>';
var_dump($currCharacDB);
echo '</pre>';


$currCharacDB->insertCharac(1, $perso1->id, $perso1->name, $perso1->health['currentPV'], $perso1->health['totalPV'], $perso1->strength['basicStrength'], $perso1->defense['basicDefense'], $perso1->esquiveBonus, $perso1->class, $perso1->weapon->id, $perso1->weapon->strength, $action1);

$currCharacDB->insertCharac(2, $perso2->id, $perso2->name, $perso2->health['currentPV'], $perso2->health['totalPV'], $perso2->strength['basicStrength'], $perso2->defense['basicDefense'], $perso2->esquiveBonus, $perso2->class, $perso2->weapon->id, $perso2->weapon->strength, $action2);

if (($perso1->health['currentPV'] <= 0) && ($perso2->health['currentPV'] <= 0)) {
    header('Location:./winner.php?win=0');
} else if ($perso2->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=1');
} else if ($perso1->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=2');
} else {
    header("Location:./game.php?status=gip");
}
