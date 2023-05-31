<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$bolas = [
    "message" => "cock"
];

echo json_encode($bolas);
/*
try {
    $pdo = new PDO('mysql:host=database;port=3306;dbname=myappdb', 'root', 'root');

    $model = $_GET['model'];
    $action = $_GET['action'];

} catch (PDOException $e) {
    echo 'Connection Failed' . $e->getMessage();
}
*/