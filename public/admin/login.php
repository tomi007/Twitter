<?php
include_once '../bootstrap.php';

$errors = [];
if(isset($_SESSION['logged']) && $_SESSION['logged'] = true){
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //wczytujemy zmienne z formularza
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
            header('Location: index.php');
        } else {
            $errors[] = 'Hasło niepoprawne';
        }
    } else {
        $errors[] = 'Brak takiego użytkownika';
    }
} else {

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twitter :: Logowanie</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
  <div class="container">

      <form class="form-signin" method="POST">
        <?php echo join('<br>', $errors); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" type="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" id="inputPassword" class="form-control" placeholder="Password" required="" type="password">
        <div class="checkbox">
          <label>
            <input value="remember-me" type="checkbox"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div>

</body>
</html>
