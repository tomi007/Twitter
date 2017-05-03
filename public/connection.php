<?php

include_once __DIR__ . '/../config/db.php';

//Poniżej napisz kod łączący się z bazą danych
$connection = new PDO(sprintf("mysql:host=%s;dbname=%s;charset=utf8", $hostname, $dbname), $user, $password);

if ($connection->errorCode() != null) {
    var_dump($connection->errorInfo());
    die();
}
