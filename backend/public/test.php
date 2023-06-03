<?php
require_once __DIR__ . '/../PDOConnector.php';
require_once __DIR__ . '/../model/personRole.php';
require_once __DIR__ . '/../model/person.php';
require_once __DIR__ . '/../model/role.php';


class Test {
    /** @var PDOConnector */
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function personRoleInsert($params) {
        $idRole = $params->idRole;
        $idPerson = $params->idPerson;

        $personRole = new PersonRole($this->pdo, $idRole, $idPerson);

        return $personRole->save();
    }

    public function personInsert($params) {
        $parsedParams = [];

        foreach($params as $key => $value) {
            $parsedParams[":$key"] = $value;
        }

        return $parsedParams;
    }
}

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");


try {
    $pdo = new PDO('mysql:host=database;port=3306;dbname=myappdb', 'root', 'root');
    $pdoConnector = new PDOConnector($pdo);

    $action = $_GET['action'];
    $post = (array) json_decode(file_get_contents('php://input'));

    $data = (object) array_merge($post, $_GET);

    $test = new Test($pdoConnector);

    $result = $test->$action($data);

    echo json_encode($result);
} catch (PDOException $e) {
    http_response_code(400);
    echo $e->getMessage();
}