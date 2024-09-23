<?php
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$arrayPerso = json_decode(file_get_contents('./data/charac.json'), true);

$someoneWins = false;

if ($_GET['win']) {
    $someoneWins = true;
    $winnerName = $arrayPerso[$_GET['win']]['name'];
    $winnerId = $arrayPerso[$_GET['win']]['id'];
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
                <form action='./index.php?state=restOfGame&win=<?= $winnerId ?>' method='POST'>
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