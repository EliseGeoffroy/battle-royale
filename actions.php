<?php

$dir = __DIR__;
require_once __DIR__ . '/includes/classPerso.php';
require_once __DIR__ . '/includes/classWeapon.php';
require_once __DIR__ . '/includes/usualFunctions.php';

$filenameCharac = $dir . '/data/charac.json';



$arrayPerso = json_decode(file_get_contents($filenameCharac), true);

$arrayPerso1 = $arrayPerso['Perso1'];
$perso1 = classChoice($arrayPerso1);

$arrayPerso2 = $arrayPerso['Perso2'];
$perso2 = classChoice($arrayPerso2);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $action1 = $_POST['action1'];
    $action2 = $_POST['action2'];

    if ($action2 != 'attack') {
        if ($action2 == 'defende') {
            $perso2->defende();
            $descrAction2 = $perso2->name . ' se met en position de défense.';
        } else {
            $perso2->special();
            $descrAction2 = $perso2->name . ' a utilisé son action spéciale : ' . $perso2->specialAction;
        }
        switch ($action1) {
            case 'defende':
                $perso1->defende();
                $descrAction1 = $perso1->name . ' se met en position de défense.';
                break;

            case 'attack':
                $descrAction1 = attack($perso1, $perso2);

                break;
            case 'special':
                $perso1->special();
                $descrAction1 = $perso1->name . ' a utilisé son action spéciale : ' . $perso1->specialAction;
                break;
        }
    } else {
        switch ($action1) {
            case 'defende':
                $perso1->defende();
                $descrAction1 = $perso1->name . ' se met en position de défense.';

                break;

            case 'attack':
                $descrAction1 = attack($perso1, $perso2);

                break;
            case 'special':
                $perso1->special();
                $descrAction1 = $perso1->name . ' a utilisé son action spéciale : ' . $perso1->specialAction;
                break;
        }
        $descrAction2 = attack($perso2, $perso1);
    }
}


$arrayPerso = [
    "Perso1" => $perso1->toJson(),
    "Perso2" => $perso2->toJson()
];

echo '<pre>';
print_r($arrayPerso);
echo '</pre>';

file_put_contents($filenameCharac, json_encode($arrayPerso, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

if (($perso1->health['currentPV'] <= 0) && ($perso2->health['currentPV'] <= 0)) {
    header('Location:./winner.php?win=');
} else if ($perso2->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=Perso1');
} else if ($perso1->health['currentPV'] <= 0) {
    header('Location:./winner.php?win=Perso2');
} else {
    header("Location:./game.php?action1=$descrAction1&action2=$descrAction2");
}
