<pre>
<?php

$dir = __DIR__;
$filenameCurrentCharacList = $dir . '/data/currentCharacList.json';
$filenameCharac = $dir . '/data/charac.json';
$filenameWeaponList = $dir . '/data/weaponList.json';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    switch ($_GET['choice']) {
        case 'charac1':

            $characList = json_decode(file_get_contents($filenameCurrentCharacList), true);
            $keyCharac = array_search($_GET['id'], array_column($characList, 'id'));
            $charac = $characList[$keyCharac];
            $charac['health'] = ['currentPV' => $charac['health'], 'totalPV' => $charac['health']];
            $charac['esquiveBonus'] = false;
            file_put_contents($filenameCharac, json_encode($charac, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            array_splice($characList, $keyCharac, 1);
            file_put_contents($filenameCurrentCharacList, json_encode($characList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            header('Location:./index.php?choice=weapon1');
            break;
        case 'weapon1':
            $currentCharac = json_decode(file_get_contents($filenameCharac), true);

            $weaponList = json_decode(file_get_contents($filenameWeaponList), true);
            $keyWeapon = array_search($_GET['id'], array_column($weaponList, 'id'));

            $currentCharac = [...$currentCharac, "weapon" => [
                'name' => $weaponList[$keyWeapon]['name'],
                'class' => $weaponList[$keyWeapon]['class'],
                'strength' => $weaponList[$keyWeapon]['strength']
            ]];

            file_put_contents($filenameCharac, json_encode($currentCharac, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header('Location:./index.php?choice=charac2');
            break;
        case 'charac2':
            $charac1 = json_decode(file_get_contents($filenameCharac), true);
            $characList = json_decode(file_get_contents($filenameCurrentCharacList), true);
            $keyCharac = array_search($_GET['id'], array_column($characList, 'id'));
            $charac2 = $characList[$keyCharac];
            $charac2['health'] = ['currentPV' => $charac2['health'], 'totalPV' => $charac2['health']];
            $charac2['esquiveBonus'] = false;
            $finalCharac = [
                'Perso1' => $charac1,
                'Perso2' => $charac2
            ];
            file_put_contents($filenameCharac, json_encode($finalCharac, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header('Location:./index.php?choice=weapon2');
            break;

        case 'weapon2':
            $currentCharac = json_decode(file_get_contents($filenameCharac), true);

            $weaponList = json_decode(file_get_contents($filenameWeaponList), true);
            $keyWeapon = array_search($_GET['id'], array_column($weaponList, 'id'));
            $currentCharac['Perso2'] = [...$currentCharac['Perso2'], "weapon" => [
                'name' => $weaponList[$keyWeapon]['name'],
                'class' => $weaponList[$keyWeapon]['class'],
                'strength' => $weaponList[$keyWeapon]['strength']
            ]];
            file_put_contents($filenameCharac, json_encode($currentCharac, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            header('Location:./game.php');
            break;
    }
}
?>
</pre>