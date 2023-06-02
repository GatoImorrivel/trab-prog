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

    public function get($params) {
        try {
            $id = $params->id;

            $person = (object) $this->pdo->query(
                "SELECT * FROM person WHERE person.idPerson = :id"
            , ["id" => $id]);

            $roles = $this->pdo->query(
                "SELECT * FROM person
                INNER JOIN personRole ON personRole.idPerson = person.idPerson
                INNER JOIN role on role.idRole = personRole.idRole
                WHERE person.idPerson = :id"
            , ["id" => $person->idPerson]);

            $person->roles = $roles;

            return $person;
        } catch (PDOException $e) {
            throw $e;
        }
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
                    "INSERT INTO personRole (idRole, idPerson) 
                    VALUES (:person, :role)"
                ,
                [
                    "person" => $idPerson,
                    "role" => $idRole,
                ]);
            } 
        } catch (PDOException $e) {
            throw $e;
        }
    }
}