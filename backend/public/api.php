<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
echo "hello";

/*
try {
    $pdo = new PDO('mysql:host=database;port=3306;dbname=myappdb', 'root', 'root');

    $model = $_GET['model'];
    $action = $_GET['action'];

} catch (PDOException $e) {
    echo 'Connection Failed' . $e->getMessage();
}
*/