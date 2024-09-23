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



if ($_GET != []) {

    $descrAction1 = $_GET['action1'];
    $descrAction2 = $_GET['action2'];
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Royale</title>
    <link rel="stylesheet" href="/public/css/index-style.css">
</head>

<body>
    <header>Battle Royale de Lily</header>
    <main>
        <div class=previousAction>
            <?= isset($descrAction1) ? '<p>' . $descrAction1 . '</p>' : '' ?>
            <?= isset($descrAction2) ? '<p>' . $descrAction2 . '</p>' : '' ?>
        </div>
        <div class=characters>
            <p> <?= $perso1 ?></p>
            <p> <?= $perso2 ?></p>
        </div>
        <form action="./actions.php" method="POST">
            <div class="action1">
                <label for="action"><?= 'Choisissez une action pour ' . $perso1->name ?></label>
                <select name="action1" id="action">
                    <option value="attack">Attaquer</option>
                    <option value="defende">Se défendre</option>
                    <option value="special"><?= $perso1->specialAction ?></option>
                </select>
            </div>
            <div class="action2">
                <label for="action"><?= 'Choisissez une action pour ' . $perso2->name ?></label>
                <select name="action2" id="action">
                    <option value="attack">Attaquer</option>
                    <option value="defende">Se défendre</option>
                    <option value="special"><?= $perso2->specialAction ?></option>
                </select>
            </div>
            <button type="Submit">Jouer le tour</button>
        </form>


    </main>
    <footer>Lily Creative Commons</footer>
</body>

</html>