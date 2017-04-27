<?php
include_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
   $id = $_GET['id'];
   // wczytanie metody statycznej w ktorej przekazujemy ID usera
   $result = User::loadUserById($connection, $id);
   // wyswietlenie danych usera
   echo "<b>ID: </b>" . $result->getId() .  "<b> username: </b>" . $result->getUsername() . "<b> mail: </b>" . $result->getEmail();
}else{
   echo "Niepoprawny link!";
}
