<?php
include_once '../bootstrap.php';
//$_SESSION['logged'] = false;
unset($_SESSION['logged']);

echo "Wylogowano. <a href='login.php'>Zaloguj sie ponownie!</a>";
