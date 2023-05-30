<?php
require_once __DIR__ . '/../model/person.php';

echo 'hello';

try {
    $pdo = new PDO('mysql:host=database;port=3306;dbname=myappdb', 'root', 'root');

    $model = $_GET['model'];
    $action = $_GET['action'];

    $model->$action();
} catch (PDOException $e) {
    echo 'Connection Failed' . $e->getMessage();
}