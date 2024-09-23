<h1>Choisissez l'arme de votre <?= ($choice == 'weapon1') ? '1er' : '2ème' ?> personnage</h1>
<div class=gallery>
    <?php foreach ($weaponList as $weapon): ?>

        <a href=<?= './init.php?choice=' . $choice . '&id=' . $weapon['id'] ?> style="text-decoration: none; color:black">
            <div class=weapon>
                <img src='<?= $weapon['picture'] ?>' style="clip:rect(0px,60px,200px,0px);overflow:hidden">
                <p class=name> <?= $weapon['name'] ?></p>
                <p class=class> <?= match ($weapon['class']) {
                                    "bow" => "Arc",
                                    "sword" => "Epée",
                                    "ax" => "Hache",
                                    default => "Inconnue"
                                } ?></p>

                <div class=features>

                    <span id='Strength'>
                        <label for='Strength'>Att</label>
                        <?= $weapon['strength'] ?>
                    </span>
                </div>
            </div>
        </a>


    <?php endforeach; ?>
</div>