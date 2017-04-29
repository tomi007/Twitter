<?php
include_once '../bootstrap.php';

if ($_SESSION != true) {
  header('Location: login.php');
}else{
  if ($_SERVER['REQUEST_METHOD'] && isset($_POST['textTweet'])) {

      $textTweet = $_POST['textTweet'];
      $tweet = new Tweet();
      $tweet->setUserId($_SESSION['userId']); // przypisujemy ID zalogowanego użytkownika
      $tweet->setText($textTweet);

      echo $tweet->getUserId();
      echo "<br>";
      echo $tweet->getText();

      $save = $tweet->save($connection);

      var_dump($save);
      if ($save) {
          // jeżeli zapisywanie tweeta powiodło się
          $_SESSION['createTweet'] = "<b>Tweet został dodany!</b>"; // zapisujemy komunikat
      }else{
          $_SESSION['createTweet'] = "<b>Błąd!</b>"; // zapisujemy komunikat
      }
  }
}

// $user = new User();
// $user->setEmail('krzystof@kris.pl');
// $user->setUsername('kris');
// $user->setHashPassword('kris');
//
// $result = $user->save($connection);
// var_dump($result);
// echo 'Mamy usera';

?>


<div class="container">
  <div class="row">
    <div class="col-md-3"><h2>USER_ID: <?php echo $_SESSION['userId'] ?></h2></div>
    <div class="col-md-6">

      <form class="" method="post">
        <?php
          if(isset($_SESSION['createTweet'])){
              echo "<b>Tweet dodany!</b>";
              unset($_SESSION['createTweet']);
          }
        ?>
        <input name="textTweet" id="textTweet" class="form-control input-lg" placeholder="Co się dzieje?" required="" autofocus="" type="text">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Tweetnij!</button>
        <label></label>
      </form>


      <?php
          if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['show'])) {
              // ładujemy tweeta po ID które podaliśmy w linku (GET)
              $loadTweet = Tweet::loadTweetById($connection, $_GET['show']);
              // echo "<pre>";
              // print_r($loadTweet);
              // echo "</pre>";
              echo "
                <div class='row'>
                    <div class='col-md-2'>
                      <img src='http://localhost/coderslab/Twitter/images/default-avatar.jpg' alt='avatar' width='70px' class='img-rounded'>
                    </div>
                    <div class='col-md-10'>
                    <a href='showUser.php?id=" . $loadTweet->getUserId() . "'>@nazwausera</a> <i>" . $loadTweet->getCreationDate() . "</i>
                    <br>
                    <p>" . $loadTweet->getText() . "</p>
                    </div>
                </div>
                <br>
                <hr>
                <h4>Komentarze do tego wpisu</h4>
              ";


          }else{

              // ROZWIĄZANIE TYMCZASOWE !!!
              // jeżeli jesteśmy na głównej stronie generujemy wszystkie Tweety
              $count = Tweet::loadAllTweets($connection); // liczy ile jest wynikow

              for ($i=1; $i < count($count); $i++) {
                $loadTweet = '';
                $loadTweet = Tweet::loadTweetById($connection, $i);

                // jeżeli ID istnieje w bazie to wyswietlamy zawartosc
                if ($loadTweet) {
                  echo "
                    <div class='row'>
                    <a href='index.php?show=" . $i . "'>
                        <div class='col-md-2'>
                          <img src='http://localhost/coderslab/Twitter/images/default-avatar.jpg' alt='avatar' width='50px' class='img-rounded'>
                        </div>
                        <div class='col-md-10'>
                        <a href='showUser.php?id=" . $loadTweet->getUserId() . "'>@nazwausera</a> <i>" . $loadTweet->getCreationDate() . "</i>
                        <br>
                        <p>" . $loadTweet->getText() . "</p>
                        </div>
                    </a>
                    </div><br>
                  ";
                }

              }
          }
      ?>
    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
