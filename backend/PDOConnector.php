<?php
class PDOConnector {

    /** @var PDO */
    private $pdo;
    private $lastInsertId;

    /** @var PDOStatement */
    private $stmt;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params) {
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        $this->stmt = $stmt;
    }

    public function getResults() {
        return $this->stmt->fetchAll();
    }

    public function getResultObj() {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getResultSingleValueArray() {
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function executeSQL($sql, $params = []) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $parsedParams = [];

            foreach($params as $key => $value) {
                $parsedParams[":$key"] = $value;
            }

            $result = $stmt->execute($parsedParams);
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getLastStatement() {
        return $this->stmt;
    }

    public function getLastInsertedId() {
        return $this->lastInsertId;
    }
}