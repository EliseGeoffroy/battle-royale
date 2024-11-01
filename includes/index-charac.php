<h1>Choisissez votre <?= ($choice == 'charac1') ? '1er' : '2ème' ?> personnage</h1>
<div class=gallery>
    <?php foreach ($characList as $charac): ?>

        <a href=<?= './init.php?choice=' . $choice . '&id=' . $charac['id'] ?> style="text-decoration: none; color:black">
            <div class=character>
                <img src='<?= $charac['picture'] ?>' style="clip:rect(0px,60px,200px,0px);overflow:hidden">
                <p class=name> <?= $charac['name'] ?></p>
                <p class=class> <?= match ($charac['class']) {
                                    "elf" => "Elfe",
                                    "man" => "Homme",
                                    "dwarf" => "Nain"
                                } ?></p>

                <div class=features>

                    <span id='Health'>
                        <label for='Health'>PV</label>
                        <?= $charac['health'] ?>
                    </span>

                    <span id='Defense'>
                        <label for='Defense'>Déf</label>
                        <?= $charac['defense'] ?>
                    </span>

                    <span id='Strength'>
                        <label for='Strength'>Att</label>
                        <?= $charac['strength'] ?>
                    </span>
                </div>
            </div>
        </a>


    <?php endforeach; ?>
</div>