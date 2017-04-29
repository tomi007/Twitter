<?php
include_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['userId'])) {
   $userId = $_GET['userId'];
   // wczytanie metody statycznej w ktorej przekazujemy ID usera
   $result = Tweet::loadAllTweetsByUserId($connection, $userId);
   
    echo '<pre>';
    print_r($result);
    echo '</pre>';
   // wyswietlenie danych usera
   //echo $result->getText();
}else{
   echo "Niepoprawny link!";
}
