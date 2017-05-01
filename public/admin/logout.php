<?php
include_once '../bootstrap.php';
//$_SESSION['logged'] = false;
unset($_SESSION['logged']);
unset($_SESSION['username']);
unset($_SESSION['userId']);

echo "Wylogowano. <a href='login.php'>Zaloguj sie ponownie!</a>";
