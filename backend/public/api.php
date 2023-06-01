<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once __DIR__ . '/../PDOConnector.php';

require_once __DIR__ . '/../model/person.php';
require_once __DIR__ . '/../model/role.php';

try {
    $pdo = new PDO('mysql:host=database;port=3306;dbname=myappdb', 'root', 'root');
    $pdoConnector = new PDOConnector($pdo);

    $model = $_GET['model'];
    $action = $_GET['action'];
    $data = json_decode(file_get_contents('php://input'));

    $obj = new $model($pdoConnector);

    $result = $obj->$action($data);

    echo json_encode($result);
} catch (PDOException $e) {
    http_response_code(400);
    echo $e->getMessage();
}