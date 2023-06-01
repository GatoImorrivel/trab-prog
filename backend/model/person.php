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
        try {
            $this->pdo->executeSQL(
                "INSERT INTO person (name, password, email) 
                VALUES (:name, :password, :email)"
            ,
            [
                "name" => $params->name,
                "password" => $params->password,
                "email" => $params->email,
            ]);

            $idPerson = $this->pdo->getLastInsertedId();
            foreach($params->roles as $idRole) {
                $this->pdo->executeSQL(
                    "INSERT INTO personRole (idPerson, idRole) 
                    VALUES (:idPerson, :idRole)"
                ,
                [
                    "idPerson" => $idPerson,
                    "idRole" => $idRole,
                ]);
            } 
        } catch (PDOException $e) {
            throw $e;
        }
    }
}