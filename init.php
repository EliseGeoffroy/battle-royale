<pre>
<?php

$dir = __DIR__;
$filenameCurrentCharacList = $dir . '/data/currentCharacList.json';
$filenameCharac = $dir . '/data/charac.json';
$filenameWeaponList = $dir . '/data/weaponList.json';

require_once('./database/pdoOpen.php');
require_once('./includes/usualFunctions.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    switch ($_GET['choice']) {
        case 'charac1':
            characChoice($_GET['id'], 1, $pdo);
            header('Location:./index.php?choice=weapon1');
            break;

        case 'weapon1':
            weaponChoice($_GET['id'], 1, $pdo);
            header('Location:./index.php?choice=charac2');
            break;

        case 'charac2':
            characChoice($_GET['id'], 2, $pdo);
            header('Location:./index.php?choice=weapon2');
            break;

        case 'weapon2':
            weaponChoice($_GET['id'], 2, $pdo);
            header('Location:./game.php?status=init');
            break;
    }
}
?>
</pre>