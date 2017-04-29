<?php
include_once '../bootstrap.php';
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header('Location: login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['username']) && $_POST['password']==$_POST['password2']){

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $user = new User();
  $user->setEmail($email);
  $user->setUsername($username);
  $user->setHashPassword($password);

  $result = $user->save($connection);
  if ($result) {
      $_SESSION['register'] = '<b>Konto założone, możesz się zalogować</b>';
      header('Location: login.php');
  }

}else{
  echo "<p><center><b>NIE PRAWIDŁOWE DANE!</b></center></p>";
}


?>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Dołącz do nas!</h2>
          <label for="inputEmail" class="sr-only">E-mail</label>
          <input name="email" id="inputEmail" class="form-control" placeholder="E-mail" required="" autofocus="" type="email">

          <label for="inputText" class="sr-only">Nazwa użytkownika</label>
          <input name="username" id="inputText" class="form-control" placeholder="Nazwa użytkownika" required="" autofocus="" type="text">

          <label for="inputPassword" class="sr-only">Hasło</label>
          <input name="password" id="inputPassword" class="form-control" placeholder="Hasło" required="" type="password">

          <label for="inputPassword" class="sr-only">Powtórz hasło</label>
          <input name="password2" id="inputPassword" class="form-control" placeholder="Ponów hasło" required="" type="password">

          <label></label>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Zarejestruj się!</button>
          <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
      </form>

    </div>
  </div>
</div>
