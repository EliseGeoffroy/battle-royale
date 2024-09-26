<?php

$dir = __DIR__;

require_once $dir . '/database/pdoOpen.php';

require_once $dir . '/includes/classPerso.php';
require_once $dir . '/includes/classWeapon.php';

require_once $dir . '/includes/objectConstruct.php';

require_once $dir . '/includes/usualFunctions.php';


if ($_GET['status'] == 'gip') {

    $descrAction1 = editDescription($pdo, $perso1, $perso2, 1);
    $descrAction2 = editDescription($pdo, $perso2, $perso1, 2);
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