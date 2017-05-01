<?php
include_once '../bootstrap.php';
//header('Location: message.php?inbox');
?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <?php
        $username = $_SESSION['username'];
        echo "Witaj, <a href='#'>$username</a><br><br>";
        echo "<a href='message.php?new'>Nowa Wiadomość</a><br>";
        echo "<a href='message.php?inbox'>Skrzynka Odbiorcza (0)</a><br>";
        echo "<a href='message.php?outbox'>Wysłane</a><br>";
        echo "<a href='logout.php'>Wyloguj się</a><br>";
      ?>
    </div>
    <div class="col-md-6">


            <?php
              if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['new'])) {
                echo "
                <h2>Nowa wiadomość</h2>
                <hr>
                <form action='message.php' class='' method='post'>

                <select name='recipient' class='form-control'>
                  <option>-Wybierz do kogo chcesz napisać--</option>
                ";


                  $loadUsers = User::loadAllUsers($connection);
                  foreach ($loadUsers as $key => $row) {
                    echo "<option>".$row->getUsername()."</option>";
                  }


                echo "
                </select>
                <textarea name='message' class='form-control' rows='3'></textarea>
                <button class='btn btn-lg btn-primary btn-block' type='submit'>Wyślij</button>
                </form>
                ";
              }

              if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['read'])) {
                  $openMessage = Message::loadMessageById($connection,$_GET['read']);

                  if ($openMessage) {
                    echo $openMessage->getRead();
                    //echo $openMessage->setRead();
                    echo "
                    <h2>Skrzynka odbiorcza</h2>
                    <div class='table-responsive'>
                      <table class='table table-striped'>
                    <tr>
                      <th>Nadawca</th>
                      <th>Wiadomość</th>
                      <th>Data</th>
                    </tr>
                    <tr>
                      <td><a href='showUser.php?id=". $openMessage->getSender() . "'>tomi</a></td>
                      <td>".$openMessage->getMessage()."</td>
                      <td></td>
                    </tr>
                    </table>";

                    echo "
                    <hr>
                    <form action='message.php' class='' method='post'>
                    <textarea class='form-control' rows='3'></textarea>
                    <button class='btn btn-lg btn-primary btn-block' type='submit' placeholder='Szybka odpowiedź'>Odpowiedz</button>
                    </form>
                    ";
                  }else{
                     echo "Błąd, nie ma takiej wiadomośći!";
                  }
              }

              if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['outbox'])) {
                 echo "Skrzynka nadawcza";
              }

              if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['inbox'])){
                  // wyswietlamy skrzynkę odbiorczą
                  $message = Message::loadAllSendMessagesByUserId($connection,$_SESSION['userId']);
                  //print_r($message);
                  if ($message) {
                        echo "
                        <h2>Skrzynka odbiorcza</h2>
                        <div class='table-responsive'>
                          <table class='table table-striped'>
                        <tr>
                          <th>Nadawca</th>
                          <th>Wiadomość</th>
                          <th>Data</th>
                        </tr>
                        ";
                    foreach ($message as $key => $value) {
                        $getMessage = $value->getMessage();
                        // $date = new DateTime($value->getCreationDate());
                        // $date->format('Y-m-d');

                        $date = new DateTime($value->getCreationDate());
                        $date = $date->format("Y-m-d"); // "9999-12-31"

                        $messageCut = substr($getMessage, 0, 40);
                        if (strlen($getMessage) >= 45) {
                            $messageCut .= "...";
                        }

                        echo "
                            <tr>
                              <td><a href='user.php?". $value->getSender() . "'>tomi</a></td>
                              <td><a href='message.php?read=1'><b>".$messageCut."</b></a><br></td>
                              <td>" . $date . "</td>
                            </tr>
                        ";

                    }
                  }else{
                    echo "<tr><td>Brak wiadomości.</td></tr>";
                  }
              }



            ?>

      </table>
    </div>

    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
