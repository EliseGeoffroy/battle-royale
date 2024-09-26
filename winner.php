<?php

$dir = __DIR__;
require_once $dir . '/database/pdoOpen.php';

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


$statement = $pdo->prepare("SELECT * FROM currcharac WHERE numPerso=:numWinner ORDER BY idRound DESC");
$statement->bindValue(':numWinner', $numWinner);
$statement->execute();
$winnerTable = $statement->fetch();
$winnerName = $winnerTable['name'];
$winnerId = $winnerTable['idCharac'];

$statement = $pdo->prepare("SELECT idWeapon, idCharac FROM currcharac WHERE numPerso=:numLoser ORDER BY idRound DESC");
$statement->bindValue(':numLoser', $numLoser);
$statement->execute();

$loserWeapon = $statement->fetch()['idWeapon'];
$loserId = $statement->fetch()['idCharac'];

$statement = $pdo->prepare("DELETE FROM currcharac");
$statement->execute();

$statement = $pdo->prepare("INSERT INTO currcharac (idRound, numPerso, idCharac, name, currHealth, totalHealth, currStrength, currDefense, esquiveBonus, class, idWeapon, currStrengthWeapon) VALUES (DEFAULT,:numPerso,:id,:name,:currHealth,:totalHealth,:currStrength,:currDefense, :esquiveBonus, :class, :idWeapon, :currStrengthWeapon)");

$statement->bindValue(':numPerso', 1);
$statement->bindValue(':id', $winnerId);
$statement->bindValue(':name', $winnerName);
$statement->bindValue(':currHealth', $winnerTable['currHealth']);
$statement->bindValue(':totalHealth', $winnerTable['totalHealth']);
$statement->bindValue(':currStrength', $winnerTable['currStrength']);
$statement->bindValue(':currDefense', $winnerTable['currDefense']);
$statement->bindValue(':class', $winnerTable['class']);
$statement->bindValue(':idWeapon', $winnerTable['idWeapon']);
$statement->bindValue(':currStrengthWeapon', $winnerTable['currStrengthWeapon']);
$statement->bindValue(':esquiveBonus', $winnerTable['esquiveBonus']);
$statement->execute();

$statement = $pdo->prepare("UPDATE characterList SET status='dead' WHERE id=:id");
$statement->bindValue(':id', $loserId);
$statement->execute();


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