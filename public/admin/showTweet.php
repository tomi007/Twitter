<?php
include_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
   $id = $_GET['id'];

   $result = Tweet::loadTweetById($connection, $id);

   echo $result->getText();
   //echo "<b>ID: </b>" . $result->getId() .  "<b> username: </b>" . $result->getUsername() . "<b> mail: </b>" . $result->getEmail();
}else{
   echo "Niepoprawny link!";
}
