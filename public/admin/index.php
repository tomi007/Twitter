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
      $save = $tweet->save($connection);
      if ($save) {
          // jeżeli zapisywanie tweeta powiodło się
          $_SESSION['createTweet'] = "<b>Tweet został dodany!</b>"; // zapisujemy komunikat
          unset($_SESSION['createTweet']);
      }else{
          $_SESSION['createTweet'] = "<b>Błąd!</b>"; // zapisujemy komunikat
          unset($_SESSION['createTweet']);
      }
  }
}
?>


<div class="container">
  <div class="row">
    <div class="col-md-3"><h2>USER_ID: <?php echo $_SESSION['userId'] ?></h2></div>
    <div class="col-md-6">
      <?php
          if (isset($_GET['show'])) {
              // ładujemy tweeta po ID które podaliśmy w linku (GET)
              $loadTweet = Tweet::loadTweetById($connection, $_GET['show']);
              // echo "<pre>";
              // print_r($loadTweet);
              // echo "</pre>";
              echo "
                <div class='row'>
                    <div class='col-md-2'>
                      <img src='http://localhost/coderslab/Twitter/images/default-avatar.jpg' alt='avatar' width='50px' class='img-rounded'>
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

              if (isset($_POST['comment']) && $_POST['comment'] != null) {
                  $addComment = new Comment();
                  $addComment->setUserId(1);
                  $addComment->setTweetId($_GET['show']);
                  $addComment->setComment($_POST['comment']);
                  $addComment->save($connection);

                  echo "<b>Komentarz dodany</b>";
                  $_POST['comment'] = null;
              }
              // wyswietlamy formularz do komentowania
              echo "<form action='index.php?show=".$_GET['show']."' class='' method='post'>";
              echo '
              <input name="comment" id="textTweet" class="form-control input-lg" placeholder="Napisz komentarz..." required="" autofocus="" type="text">
              <button class="btn btn-lg btn-primary btn-block" type="submit">Skomentuj!</button>
              <label></label>
              </form><br>
              ';

              // ładujemy metodę statyczna pobierającą wszystkie Komentarze
              $comment = Comment::loadAllCommentByTweetId($connection,$_GET['show']);

              // jeżeli istnieją komentarze w bazie
              if ($comment) {
                  // wylistowanie wszystkich komentarzy
                  foreach ($comment as $key => $value) {
                      echo "
                        <div class='row'>
                            <div class='col-md-2'>
                              <img src='http://localhost/coderslab/Twitter/images/default-avatar.jpg' alt='avatar' width='50px' class='img-rounded'>
                            </div>
                            <div class='col-md-10'>
                            <a href='showUser.php?id=" . $value->getUserId() . "'>@nazwausera</a> <i>" . $value->getCreationDate() . "</i>
                            <br>
                            <p>" . $value->getComment() . "</p>
                            </div>
                        </div><br>
                      ";

                  }
              }else{
                  echo "Brak komentarzy.";
              }


          }else{
                echo ' <form class="" method="post">';

                if(isset($_SESSION['createTweet'])){
                    echo "<b>Tweet dodany!</b>";
                    unset($_SESSION['createTweet']);
                }

                echo '
                <input name="textTweet" id="textTweet" class="form-control input-lg" placeholder="Co się dzieje?" required="" autofocus="" type="text">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Tweetnij!</button>
                <label></label>
                </form>
                ';

              // ładujemy metodę statyczną pobierającą wszystkie Wpisy
              $allTweets = Tweet::loadAllTweets($connection);

              // wypisujemy wszystkie wpisy
              foreach ($allTweets as $key => $value) {
                echo "
                  <div class='row'>
                  <a href='index.php?show=" . $value->getId() . "'>
                      <div class='col-md-2'>
                        <img src='http://localhost/coderslab/Twitter/images/default-avatar.jpg' alt='avatar' width='40px' class='img-rounded'>
                      </div>
                      <div class='col-md-10'>
                      <a href='showUser.php?id=" . $value->getUserId() . "'>@nazwausera</a> <i>" . $value->getCreationDate() . "</i>
                      <br>
                      <p>" . $value->getText() . "</p>
                      </div>
                  </a>
                  </div><br>
                ";
              }
          }
      ?>
    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
