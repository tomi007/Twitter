<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    die('użytkownik musi być zalogowany');
}

$user = new User();
$user->setEmail('ttt@ttt.pl');
$user->setUsername('test');
$user->setHashPassword('password');

$result = $user->save($connection);
echo 'Mamy usera';
