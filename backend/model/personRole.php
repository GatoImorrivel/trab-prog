<?php

require_once __DIR__ . '/../PDOConnector.php';

class PersonRole {
    private $idRole;
    private $idPerson;

    /** @var PDOConnector */
    private $pdo;

    public function __construct($pdo, $idRole, $idPerson) {
        $this->idRole = $idRole;
        $this->idPerson = $idPerson;
        $this->pdo = $pdo;
    }

    public function save() {
        try {
            $this->pdo->executeSQL(
                "INSERT INTO personRole (idRole, idPerson) 
                VALUES 
                (:idRole, :idPerson)"
            , ["idRole" => $this->idRole, "idPerson" => $this->idPerson]);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}