<?php
include_once '../bootstrap.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // wczytujemy zmienne z formularza
    $email = $_POST['email'];
    $password = $_POST['password'];

    // wywolujemy metodę statyczną
    $user = User::showUserByEmail($connection, $email);

    // jeżeli email istnieje..
    if ($user) {
        // sprawdzamy czy hasło się zgadza
        if ($user->getHashPassword() == $password) {
            $_SESSION['logged'] = true;
            echo "ZALOGOWANY";
        } else {
            $errors[] = 'Hasło niepoprawne';
        }
    } else {
        $errors[] = 'Brak takiego użytkownika';
    }
} else {

}
?>

<html>
<body>
<form method="POST">
    <?php echo join('<br>', $errors); ?>
    <br>
    Email: <input name="email">
    <br>
    Haslo: <input name="password" type="password">
    <br>
    <button type="submit">Loguj</button>
</form>
</body>
</html>
