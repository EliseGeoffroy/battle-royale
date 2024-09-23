<?php

require_once('../database/pdoOpen.php');

//weapon table
$arrayWeaponList = json_decode(file_get_contents('./WeaponList.json'), true);

$statement = $pdo->prepare("CREATE TABLE weapon  (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(45), picture VARCHAR(100), strength INT, class VARCHAR(45), PRIMARY KEY (id)) ");
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
  `class` VARCHAR(20) NOT NULL,
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

$statement = $pdo->prepare("CREATE TABLE currcharac (`numPerso` INT NOTNULL, `name` VARCHAR(45), `picture` VARCHAR(100), `currHealth` INT, `totalHealth` INT, `currStrength` INT, `currDefense` INT, `class` VARCHAR(20), `idWeapon` INT)");
$statement->execute();
