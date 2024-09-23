<?php

$filenameCharacList = __DIR__ . '/data/CharacList.json';
$filenameCurrentCharacList = __DIR__ . '/data/currentCharacList.json';
$filenameCharac = __DIR__ . '/data/charac.json';

$filenameWeaponList = __DIR__ . '/data/weaponList.json';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (isset($_GET['state'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $arrayLastPerso = json_decode(file_get_contents($filenameCharac), true);

    $arrayPerso1 = $arrayLastPerso['Perso1'];
    $arrayPerso2 = $arrayLastPerso['Perso2'];

    if ($arrayPerso1['id'] == $_GET['win']) {
        $arrayWinner = $arrayPerso1;
        $arrayLoser = $arrayPerso2;
    } else {
        $arrayWinner = $arrayPerso2;
        $arrayLoser = $arrayPerso1;
    }

    if ($_POST['weaponSwap']) {
        $arrayWinner['weapon'] = $arrayLoser['weapon'];
    }

    file_put_contents($filenameCharac, json_encode($arrayWinner, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    $characList = json_decode(file_get_contents($filenameCurrentCharacList), true);
    $keyCharac = array_search($arrayLoser['id'], array_column($characList, 'id'));
    $charac = $characList[$keyCharac];
    array_splice($characList, $keyCharac, 1);
    file_put_contents($filenameCurrentCharacList, json_encode($characList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    $choice = 'charac2';
} else {
    if (isset($_GET['choice'])) {
        $choice = $_GET['choice'];
    } else {
        $choice = 'charac1';

        copy($filenameCharacList, $filenameCurrentCharacList);
    }
}

if (($choice == 'charac1') || ($choice == 'charac2')) {


    $characList = json_decode(file_get_contents($filenameCurrentCharacList), true);
} else {


    $weaponList = json_decode(file_get_contents($filenameWeaponList), true);
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