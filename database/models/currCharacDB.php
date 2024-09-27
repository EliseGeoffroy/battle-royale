<?php

class CurrCharacDB
{
    private PDOStatement $statementUpdateWeapon;
    private PDOStatement $statementInsertCharac;
    private PDOStatement $statementSelectOne;
    private PDOStatement $statementSelectOneId;
    private PDOStatement $statementSelectOneAction;
    private PDOStatement $statementDelete;


    function __construct(private $pdo)
    {
        $this->statementUpdateWeapon = $pdo->prepare("UPDATE currcharac SET idWeapon=:id, currStrengthWeapon=:strengthWeapon WHERE numPerso=:numPerso");
        $this->statementInsertCharac = $pdo->prepare("INSERT INTO currcharac (idRound, numPerso, idCharac, name, currHealth, totalHealth, currStrength, currDefense, esquiveBonus, class, idWeapon,currStrengthWeapon,action) 
                                                    VALUES (DEFAULT,:numPerso,:id,:name,:currHealth,:totalHealth,:currStrength,:currDefense, :esquiveBonus, :class,:idWeapon,:currStrengthWeapon,:action)");
        $this->statementSelectOne = $pdo->prepare("SELECT * FROM currcharac WHERE numPerso=:numPerso ORDER BY idRound DESC");
        $this->statementSelectOneId = $pdo->prepare("SELECT idCharac FROM currcharac WHERE numPerso=:numPerso");
        $this->statementSelectOneAction = $pdo->prepare("SELECT action FROM currcharac WHERE numPerso=:numPerso ORDER BY idRound DESC");
        $this->statementDelete = $pdo->prepare("DELETE FROM currcharac");
    }

    function updateWeapon($idWeapon, $strengthWeapon, $numPerso)
    {
        $this->statementUpdateWeapon->bindValue(':id', $idWeapon);
        $this->statementUpdateWeapon->bindValue(':strengthWeapon', $strengthWeapon);
        $this->statementUpdateWeapon->bindValue(':numPerso', $numPerso);
        $this->statementUpdateWeapon->execute();
    }

    function insertCharac($numPerso, $id, $name, $currHealth, $totalHealth, $strength, $defense, $esquiveBonus, $class, $idWeapon = null, $strengthWeapon = null, $action = null)
    {
        $this->statementInsertCharac->bindValue(':numPerso', $numPerso);
        $this->statementInsertCharac->bindValue(':id', $id);
        $this->statementInsertCharac->bindValue(':name', $name);
        $this->statementInsertCharac->bindValue(':currHealth', $currHealth);
        $this->statementInsertCharac->bindValue(':totalHealth', $totalHealth);
        $this->statementInsertCharac->bindValue(':currStrength', $strength);
        $this->statementInsertCharac->bindValue(':currDefense', $defense);
        $this->statementInsertCharac->bindValue(':class', $class);
        $this->statementInsertCharac->bindValue(':esquiveBonus', $esquiveBonus);
        $this->statementInsertCharac->bindValue(':idWeapon', $idWeapon);
        $this->statementInsertCharac->bindValue(':currStrengthWeapon', $strengthWeapon);
        $this->statementInsertCharac->bindValue(':action', $action);

        $this->statementInsertCharac->execute();
    }

    function selectOne($numPerso)
    {
        $this->statementSelectOne->bindValue(':numPerso', $numPerso);
        $this->statementSelectOne->execute();
        return $this->statementSelectOne->fetch();
    }

    function selectOneId($numPerso)
    {
        $this->statementSelectOneId->bindValue(':numPerso', $numPerso);
        $this->statementSelectOneId->execute();
        return $this->statementSelectOneId->fetch();
    }

    function selectOneAction($numPerso)
    {
        $this->statementSelectOneAction->bindValue(':numPerso', $numPerso);
        $this->statementSelectOneAction->execute();
        return $this->statementSelectOneAction->fetch();
    }

    function delete()
    {
        $this->statementDelete->execute();
    }
}
return new CurrCharacDB($pdo);
