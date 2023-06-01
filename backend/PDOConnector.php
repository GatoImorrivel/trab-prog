<?php
class PDOConnector {

    /** @var PDO */
    private $pdo;

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
            $stmt = $this->pdo->prepare($sql);

            foreach($params as $key => $value) {
                $stmt->bindParam(':'.$key, $value);
            }

            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}