<?php

$dir = __DIR__;

$characterListDB = require_once $dir . '/database/models/characterListDB.php';
$currCharacDB = require_once $dir . '/database/models/currCharacDB.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

switch ($_GET['win']) {
    case 0:
        $someoneWins = false;
        break;
    case 1:
        $someoneWins = true;
        $numWinner = 1;
        $numLoser = 2;
        break;
    case 2:
        $someoneWins = true;
        $numWinner = 2;
        $numLoser = 1;
        break;
}



if ($someoneWins) {

    $winnerTable = $currCharacDB->selectOne($numWinner);
    $winnerName = $winnerTable['name'];
    $winnerId = $winnerTable['idCharac'];

    $loserTable = $currCharacDB->selectOne($numLoser);
    $loserWeapon = $loserTable['idWeapon'];
    $loserId = $loserTable['idCharac'];

    $currCharacDB->delete();

    $currCharacDB->insertCharac(1, $winnerId, $winnerName, $winnerTable['currHealth'], $winnerTable['totalHealth'], $winnerTable['currStrength'], $winnerTable['currDefense'],  $winnerTable['esquiveBonus'], $winnerTable['class'], $winnerTable['idWeapon'], $winnerTable['currStrengthWeapon']);

    $characterListDB->updateStatus('dead', $loserId);
} else {
    $perso1Id = $currCharacDB->selectOneId(1);
    $perso2Id = $currCharacDB->selectOneId(2);
    $characterListDB->updateStatus('dead', $perso1Id);
    $characterListDB->updateStatus('dead', $perso2Id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Royale</title>
    <link rel="stylesheet" href="/public/css/winner-style.css">
</head>

<body>
    <header>Battle Royale de Lily</header>
    <main>

        <div class="result">

            <?php if ($someoneWins): ?>
                <img src='https://tse2.mm.bing.net/th?id=OIP.53toWuGVARbPC2H3ZryQZwHaIS&pid=Api'>
                <p>Et le gagnant est <?= $winnerName ?></p>
                <img src='https://tse2.mm.bing.net/th?id=OIP.53toWuGVARbPC2H3ZryQZwHaIS&pid=Api'>
            <?php else: ?>
                <img src='https://tse2.mm.bing.net/th?id=OIP.0DTrUGVuNctCQjeVr74IHwHaI_&pid=Api'>
                <p>Il n'y a que des perdants à la guerre. Peace&Love, les amis!</p>
                <img src='https://tse2.mm.bing.net/th?id=OIP.0DTrUGVuNctCQjeVr74IHwHaI_&pid=Api'>
            <?php endif; ?>
        </div>

        <?php if ($someoneWins): ?>
            <div class=restOfGame>
                <form action='./index.php?state=restOfGame&win=<?= $winnerId ?>&loserWeapon=<?= $loserWeapon ?>' method='POST'>
                    <div class=weaponSwap>
                        <label for='weaponSwap'>Voulez-vous récupérer l'arme de votre ennemi ?</label>
                        <input type='checkbox' id='weaponSwap' name='weaponSwap'>
                    </div>
                    <button type='submit'>Poursuivre la battle Royale</button>
                </form>
            </div>
        <?php endif; ?>

        <div class=giveUp>
            <a href='./index.php' style='text-decoration: none;'>
                <button>Réinitialiser la battle Royale</button>
            </a>
        </div>


    </main>
    <footer>Lily Creative Commons</footer>
</body>

</html>