<?php

require_once('./database/pdoOpen.php');

$filenameCharacList = __DIR__ . '/data/CharacList.json';
$filenameCurrentCharacList = __DIR__ . '/data/currentCharacList.json';
$filenameCharac = __DIR__ . '/data/charac.json';

$filenameWeaponList = __DIR__ . '/data/weaponList.json';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($_GET['state'])) {

    if ($_POST['weaponSwap']) {

        $idWeapon = $_GET['loserWeapon'];

        $statement = $pdo->prepare("SELECT strength FROM weapon WHERE id=:id");

        $statement->bindValue(':id', $idWeapon);
        $statement->execute();
        $strengthWeapon = $statement->fetch()['strength'];


        $statement = $pdo->prepare("UPDATE currcharac SET idWeapon=:idWeapon, currStrengthWeapon=:strengthWeapon WHERE idCharac=:idCharac");
        $statement->bindValue(':idWeapon', $idWeapon);
        $statement->bindValue(':strengthWeapon', $strengthWeapon);
        $statement->bindValue(':idCharac', $_GET['win']);

        $statement->execute();
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

    $statement = $pdo->prepare("SELECT id, name, picture, strength, defense, health, class FROM characterList  WHERE status='available'");
    $statement->execute();
    $characList = $statement->fetchAll();
} else {
    $statement = $pdo->prepare("SELECT id, name, picture, strength, class FROM weapon  ");
    $statement->execute();
    $weaponList = $statement->fetchAll();
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