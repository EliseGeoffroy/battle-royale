<pre>
<?php

$dir = __DIR__;



$characterListDB = require_once($dir . '/database/models/CharacterListDB.php');
$currCharacDB = require_once($dir . '/database/models/currCharacDB.php');
$weaponDB = require_once($dir . '/database/models/weaponDB.php');


require_once('./includes/usualFunctions.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    switch ($_GET['choice']) {
        case 'charac1':
            characChoice($_GET['id'], 1, $characterListDB, $currCharacDB);
            header('Location:./index.php?choice=weapon1');
            break;

        case 'weapon1':
            weaponChoice($_GET['id'], 1, $currCharacDB, $weaponDB);
            header('Location:./index.php?choice=charac2');
            break;

        case 'charac2':
            characChoice($_GET['id'], 2, $characterListDB, $currCharacDB);
            header('Location:./index.php?choice=weapon2');
            break;

        case 'weapon2':
            weaponChoice($_GET['id'], 2, $currCharacDB, $weaponDB);
            header('Location:./game.php?status=init');
            break;
    }
}
?>
</pre>