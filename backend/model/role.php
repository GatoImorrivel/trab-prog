<?php

require_once __DIR__ . '/../PDOConnector.php';

class Role {
    /** @var PDOConnector */
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query(
            "SELECT * FROM role"
        , []);
    }

    public function save($params) {
        return $this->pdo->executeSQL(
            "INSERT INTO role (role.role) 
            VALUES (:role)"
        ,["role" => $params->role]);
    }
}