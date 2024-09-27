<?php

class WeaponDB
{

    private PDOStatement $statementSelectStrength;
    private PDOStatement $statementSelectOne;
    private PDOStatement $statementSelectAll;

    function __construct(private $pdo)
    {
        $this->statementSelectStrength = $pdo->prepare("SELECT strength FROM weapon WHERE id=:id");
        $this->statementSelectOne = $pdo->prepare("SELECT name, strength, class FROM weapon WHERE id=:id");
        $this->statementSelectAll = $pdo->prepare("SELECT id, name, picture, strength, class FROM weapon");
    }

    function selectStrength($idWeapon)
    {
        $this->statementSelectStrength->bindValue(':id', $idWeapon);
        $this->statementSelectStrength->execute();
        return $this->statementSelectStrength->fetch();
    }

    function selectOne($idWeapon)
    {
        $this->statementSelectOne->bindValue(':id', $idWeapon);
        $this->statementSelectOne->execute();
        return $this->statementSelectOne->fetch();
    }

    function selectAll()
    {
        $this->statementSelectAll->execute();
        return $this->statementSelectAll->fetchAll();
    }
}

return new WeaponDB($pdo);
