<?php

require_once('../database/pdoOpen.php');

$statement = $pdo->prepare("DROP TABLE weapon");
$statement->execute();

$statement = $pdo->prepare("DROP TABLE currCharac");
$statement->execute();

$statement = $pdo->prepare("DROP TABLE characterList");
$statement->execute();

//weapon table
$arrayWeaponList = json_decode(file_get_contents('./WeaponList.json'), true);

$statement = $pdo->prepare("CREATE TABLE weapon  (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(45), picture VARCHAR(100), strength INT NOT NULL, class ENUM ('bow','sword','ax') NOT NULL, PRIMARY KEY (id)) ");
$statement->execute();

$statement = $pdo->prepare("INSERT INTO weapon (id, name, picture, strength, class) VALUES (DEFAULT, :name, :picture, :strength, :class)");

$name = '';
$picture = '';
$strength = '';
$class = '';

$statement->bindParam(':name', $name);
$statement->bindParam(':picture', $picture);
$statement->bindParam(':strength', $strength);
$statement->bindParam(':class', $class);

foreach ($arrayWeaponList as $weapon) {
  $name = $weapon['name'];
  $picture = $weapon['picture'];
  $strength = $weapon['strength'];
  $class = $weapon['class'];

  $statement->execute();
}

//characterList table
$arrayCharacList = json_decode(file_get_contents('./characList.json'), true);

$statement = $pdo->prepare("CREATE TABLE `battleroyale`.`characterList` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `picture` VARCHAR(100) NOT NULL,
  `strength` INT NOT NULL,
  `defense` INT NOT NULL,
  `health` INT NOT NULL,
  `class` ENUM ('elf','man','dwarf') NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`));");

$statement->execute();

$statement = $pdo->prepare("INSERT INTO `battleroyale`.`characterList` (`name`, `picture`, `strength`, `defense`, `health`, `class`, `status`) VALUES (:name, :picture, :strength, :defense, :health, :class, :status);");

$name = '';
$picture = '';
$strength = '';
$defense = '';
$health = '';
$class = '';
$status = 'available';

$statement->bindParam(':name', $name);
$statement->bindParam(':picture', $picture);
$statement->bindParam(':strength', $strength);
$statement->bindParam(':defense', $defense);
$statement->bindParam(':health', $health);
$statement->bindParam(':class', $class);
$statement->bindParam(':status', $status);

foreach ($arrayCharacList as $charac) {
  $name = $charac['name'];
  $picture = $charac['picture'];
  $strength = $charac['strength'];
  $defense = $charac['defense'];
  $health = $charac['health'];
  $class = $charac['class'];

  $statement->execute();
}

//current character table

$statement = $pdo->prepare("CREATE TABLE currcharac (`idRound` INT AUTO_INCREMENT NOT NULL, `numPerso` INT NOT NULL, `idCharac` INT , `currHealth` INT, `currStrength` INT, `currDefense` INT, `esquiveBonus` BOOLEAN, `idWeapon` INT, `currStrengthWeapon` INT, `action` VARCHAR(45), PRIMARY KEY (idRound))");
$statement->execute();


$statement = $pdo->prepare("ALTER TABLE `battleroyale`.`currcharac` 
ADD INDEX `FK_currCharac_characterList_idx` (`idCharac` ASC) VISIBLE,
ADD INDEX `FK_currCharac_weapon_idx` (`idWeapon` ASC) VISIBLE;
;
ALTER TABLE `battleroyale`.`currcharac` 
ADD CONSTRAINT `FK_currCharac_characterList`
  FOREIGN KEY (`idCharac`)
  REFERENCES `battleroyale`.`characterlist` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_currCharac_weapon`
  FOREIGN KEY (`idWeapon`)
  REFERENCES `battleroyale`.`weapon` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;");

$statement->execute();
