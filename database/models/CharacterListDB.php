<?php

require_once $dir . '/database/pdoOpen.php';

class CharacterListDB
{
    private PDOStatement $statementSelectAll;
    private PDOStatement $statementSelectById;
    private PDOStatement $statementUpdateStatus;
    private PDOStatement $statementUpdateAllStatus;



    function __construct(private $pdo)
    {
        $this->statementSelectAll = $pdo->prepare("SELECT id, name, picture, strength, defense, health, class FROM characterList  WHERE status='available'");

        $this->statementSelectById = $pdo->prepare("SELECT id, name, strength, defense, health, class FROM characterlist WHERE id=:id");

        $this->statementUpdateStatus = $pdo->prepare("UPDATE characterList SET status=:status WHERE id=:id");

        $this->statementUpdateAllStatus = $pdo->prepare("UPDATE characterList SET status=:status");
    }


    function selectAll()
    {
        $this->statementSelectAll->execute();
        return  $this->statementSelectAll->fetchAll();
    }

    function selectById($id)
    {
        $this->statementSelectById->bindValue(':id', $id);
        $this->statementSelectById->execute();
        return $this->statementSelectById->fetch();
    }

    function updateStatus($status, $id)
    {
        $this->statementUpdateStatus->bindValue(':id', $id);
        $this->statementUpdateStatus->bindValue(':status', $status);
        $this->statementUpdateStatus->execute();
    }

    function updateAllStatus($status)
    {
        $this->statementUpdateAllStatus->bindValue(':status', $status);
        $this->statementUpdateAllStatus->execute();
    }
}

return new CharacterListDB($pdo);
