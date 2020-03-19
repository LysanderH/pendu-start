<?php


class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function selectWord($index)
    {
        $statement = $this->pdo->prepare("SELECT word FROM words WHERE id = {$index}");
        $statement->execute();
        return $statement->fetchAll(7);
    }
    public function count(){
        $statement = $this->pdo->prepare("SELECT count(*) FROM words");
        $statement->execute();
        return $statement->fetchAll(7);
    }
}