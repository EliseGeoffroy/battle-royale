<?php

require_once('./database/pdoOpen.php');
$characterListDB = require_once('./database/models/CharacterListDB.php');
$currCharacDB = require_once('./database/models/currCharacDB.php');
$weaponDB = require_once('./database/models/weaponDB.php');



$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($_GET['state'])) {

    if ($_POST['weaponSwap']) {

        $idWeapon = $_GET['loserWeapon'];

        $strengthWeapon = $weaponDB->selectStrength($idWeapon)['strength'];

        $currCharacDB->updateWeapon($idWeapon, $strengthWeapon, 1);
    }

    $choice = 'charac2';
} else {
    if (isset($_GET['choice'])) {
        $choice = $_GET['choice'];
    } else {
        $choice = 'charac1';
    }
}

if (($choice == 'charac1') || ($choice == 'charac2')) {
    $characList = $characterListDB->selectAll();
} else {
    $weaponList = $weaponDB->selectAll();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Royale</title>
    <link rel="stylesheet" href="/public/css/init-style.css">
</head>

<body>
    <header>Battle Royale de Lily</header>
    <main>

        <?php if (($choice == 'charac1') || ($choice == 'charac2')):
            require_once __DIR__ . '/includes/index-charac.php';

        else:
            require_once __DIR__ . '/includes/index-weapon.php';
        endif;
        ?>
    </main>
    <footer>Lily Creative Commons</footer>
</body>

</html>