<?php
class PDOConnector {

    /** @var PDO */
    private $pdo;
    private $lastInsertId;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params) {
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function executeSQL($sql, $params = []) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);

            foreach($params as $key => $value) {
                $stmt->bindParam(':'.$key, $value);
            }

            $result = $stmt->execute();
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getLastInsertedId() {
        return $this->lastInsertId;
    }
}