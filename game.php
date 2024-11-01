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


if ($_GET['status'] == 'gip') {

    $descrAction1 = editDescription($perso1, $perso2, 1, $currCharacDB);
    $descrAction2 = editDescription($perso2, $perso1, 2, $currCharacDB);
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


            <?= actionChoice('action1', $perso1) ?>
            <?= actionChoice('action2', $perso2) ?>

            <button type="Submit">Jouer le tour</button>
        </form>


    </main>
    <footer>Lily Creative Commons</footer>
</body>

</html>