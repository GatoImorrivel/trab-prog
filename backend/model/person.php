<?php

require_once __DIR__ . '/../PDOConnector.php';

class Person {
    /** @var PDOConnector */
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query(
            "SELECT * FROM person"
        , []);
    }

    public function save($params) {
        return $this->pdo->executeSQL(
            "INSERT INTO person (name, password, email, birth) 
            VALUES (:name, :password, :email, :birth)"
        ,
        [
            "name" => $params->name,
            "password" => $params->password,
            "email" => $params->email,
            "birth" => $params->birth
        ]);
    }
}