<?php

require_once __DIR__ . '/../PDOConnector.php';
require_once __DIR__ . '/personRole.php';

class Person {
    /** @var PDOConnector */
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $this->pdo->query(
            "SELECT * FROM person"
        , []);

        $people = $this->pdo->getResultObj();

        foreach($people as $person) {
            if (!empty($person->birth)) {
                $date = DateTime::createFromFormat('Y-m-d', $person->birth);
                $person->birth = $date->format('d/m/Y');
            }
        }

        return $people;
    }

    public function update($params) {
        $date = DateTime::createFromFormat('d/m/Y', $params->birth);
        $sqlDate = $date->format('Y-m-d');
        try {
            $this->pdo->executeSQL(
                "UPDATE person 
                SET name = :name, password = :password, email = :email, birth = :birth
                WHERE person.idPerson = :id"
            ,
            [
                "id" => $params->id,
                "name" => $params->name,
                "password" => $params->password,
                "email" => $params->email,
                "birth" => $sqlDate,
            ]);

            $this->pdo->executeSQL(
                "DELETE FROM personRole WHERE personRole.idPerson = :id",
                ["id" => $params->id]
            );

            foreach($params->roles as $idRole) {
                $personRole = new PersonRole($this->pdo, $idRole, $params->id);
                $personRole->save();
            } 
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function get($params) {
        try {
            $id = $params->id;

            $this->pdo->query(
                "SELECT * FROM person WHERE person.idPerson = :id"
            , ["id" => $id]);

            $person = (object) $this->pdo->getResultObj()[0];

            $this->pdo->query(
                "SELECT role.idRole FROM person
                INNER JOIN personRole ON personRole.idPerson = person.idPerson
                INNER JOIN role on role.idRole = personRole.idRole
                WHERE person.idPerson = :id"
            , ["id" => $person->idPerson]);

            $roles = $this->pdo->getResultSingleValueArray();

            $person->roles = $roles;

            if (!empty($person->birth)) {
                $date = DateTime::createFromFormat('Y-m-d', $person->birth);
                $person->birth = $date->format('d/m/Y');
            }

            return $person;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function save($params) {
        $date = DateTime::createFromFormat('d/m/Y', $params->birth);
        $sqlDate = $date->format('Y-m-d');
        try {
            $this->pdo->executeSQL(
                "INSERT INTO person (name, password, email, birth) 
                VALUES (:name, :password, :email, :birth)"
            ,
            [
                "name" => $params->name,
                "password" => $params->password,
                "email" => $params->email,
                "birth" => $sqlDate,
            ]);

            $idPerson = $this->pdo->getLastInsertedId();
            foreach($params->roles as $idRole) {
                $personRole = new PersonRole($this->pdo, $idRole, $idPerson);
                $personRole->save();
            } 
        } catch (PDOException $e) {
            throw $e;
        }
    }
}