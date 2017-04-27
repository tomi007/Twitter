<?php
include_once '../bootstrap.php';

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    die('użytkownik musi być zalogowany');
}

$user = new User();
$user->setEmail('krzystof@kris.pl');
$user->setUsername('kris');
$user->setHashPassword('kris');

$result = $user->save($connection);
var_dump($result);
echo 'Mamy usera';
?>

<form class="" action="" method="post">
  E-mail: <input type="text" name="email" value=""> <br>
  Powtórz E-mail: <input type="text" name="email2" value=""> <br>
  Hasło: <input type="password" name="password" value=""> <br>
  <input type="submit" name="" value="Zarejestruj się">
</form>
