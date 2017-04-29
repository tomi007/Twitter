<?php
include_once '../bootstrap.php';

if ($_SESSION != true) {
  header('Location: login.php');
}else{
  if ($_SERVER['REQUEST_METHOD'] && isset($_POST['textTweet'])) {
      $_SESSION['createTweet'] = "<b>Tweet został dodany!</b>";
      echo "Wysłano tweeta";
      echo $_POST['textTweet'];
  }
}

?>


<div class="container">
  <div class="row">
    <div class="col-md-3">[miejsce na profil]</div>
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
          $result = Tweet::loadAllTweets($connection);
          foreach ($result as $row) {
              var_dump($row);
          }
      ?>
    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
