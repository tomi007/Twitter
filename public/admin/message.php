<?php
include_once '../bootstrap.php';
if ($_SESSION != true) {
  header('Location: login.php');
}
//header('Location: message.php?inbox');
?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <?php
        $username = $_SESSION['username'];
        echo "Witaj, <a href='#'>$username</a><br><br>";
        echo "<a href='message.php?new'>Nowa Wiadomość</a><br>";
        echo "<a href='message.php?inbox'>Skrzynka Odbiorcza <b>(";

          $messageUnread = Message::howMuchUnreadMessage($connection, $_SESSION['userId']);
          echo count($messageUnread);

        echo ")</b></a><br>";
        echo "<a href='message.php?outbox'>Wysłane</a><br>";

      ?>
    </div>
    <div class="col-md-6">
            <?php
              ///////////////////// OBSLUGA WYSYLANIA WIADOMOSCI ///////////////////////////////
              if ($_SERVER['REQUEST_METHOD'] == "POST") {
                  if (isset($_POST['recipient']) && isset($_POST['message'])) {
                      // tworzymy obiekt do ktorego zapisujemy dane z formularza
                      $sendMessage = new Message();

                      // pobieramy ID użytkownika do którego wysyłamy wiadomosc
                      $userRecipientId = User::showUserByUsername($connection, $_POST['recipient']);
                      // przypisujemy do zmiennej ID uzytkownika
                      $userRecipientId = $userRecipientId->getId();

                      $sendMessage->setSender($_SESSION['userId']);
                      $sendMessage->setRecipient($userRecipientId);
                      $sendMessage->setMessage($_POST['message']);
                      $sendOk = $sendMessage->save($connection);

                      // jezeli wiadomosc zostala wyslana dajemy komunikat
                      if ($sendOk) {
                          echo "<p class='bg-success'>Wiadomość Poprawnie wysłana</p>";
                      }else{
                          echo "<p class='bg-success'>bład wiadomość nie została wysłana!</p>";
                      }
                  }else{
                      echo "<p class='bg-success'>Wypełnij wszystkie pole formularza!</p>";
                  }
              }else{
                  //header('Location: message.php?new');
              }
              ////////////////// KONIEC WYSYLKI WIADOMOSCI //////////////////////////////

              ////////////////////////////// WRITE ////////////////////////////////////
              if (isset($_GET['new'])) {
                  echo "
                  <h2>Nowa wiadomość</h2>

                  <form action='message.php' class='' method='post'>

                  <select name='recipient' class='form-control'>
                    <option>-Wybierz do kogo chcesz napisać--</option>
                  ";
                    // ładujemy wszystkich USERÓW (oprócz obecnie zalogowanego)
                    $loadUsers = User::loadAllUsers($connection);
                    foreach ($loadUsers as $key => $row) {
                      if ($row->getUsername() == $_SESSION['username']) {
                        // nie wyswietlamy uzytkownika ktory jest obecnie zalogowane
                      }else{
                          echo "<option>".$row->getUsername()."</option>";
                      }
                    }


                  echo "
                  </select>
                  <textarea name='message' class='form-control' rows='3'></textarea>
                  <button class='btn btn-lg btn-primary btn-block' type='submit'>Wyślij</button>
                  </form>
                  ";
              }
              ////////////////////////////// KONIEC WRITE ////////////////////////////////////

              ////////////////////////////// READ ////////////////////////////////////
              if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['read'])) {
                  $openMessage = Message::loadMessageById($connection,$_GET['read']);
                  $date = new DateTime($openMessage->getCreationDate());
                  $date = $date->format("Y-m-d");

                  // pobieramy informacje o uzytkowniku
                  $userNameSender = User::loadUserById($connection, $openMessage->getSender());

                  if ($openMessage->getRecipient() == $_SESSION['userId']) {
                    // jezeli uzytkownik wyswietlil wiadomosc
                    $openMessage->setRead(1);
                    echo $openMessage->getRead();
                    // zapisujemy informacje w bazie
                    $resultSave = $openMessage->saveToDB($connection);

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
                      <td><a href='showUser.php?id=". $openMessage->getSender() . "'>" . $userNameSender->getUsername() . "</a></td>
                      <td>";

                      echo $openMessage->getMessage();

                      echo
                      "</td>
                      <td></td>
                    </tr>
                    </table>";

                    echo "
                    <hr>
                    <form action='message.php' class='' method='post'>
                    <textarea class='form-control' rows='3'></textarea>
                    <button class='btn btn-lg btn-primary btn-block' type='submit' placeholder='Szybka odpowiedź'>Odpowiedz</button>
                    </form>
                    </table>
                    </div>
                    ";
                  }else if($openMessage->getSender() == $_SESSION['userId']){
                    // pobieramy informacje o uzytkowniku
                    $userNameRecipient = User::loadUserById($connection, $openMessage->getRecipient());

                    echo "
                    <h2>Wysłane</h2>
                    <div class='table-responsive'>
                      <table class='table table-striped'>
                    <tr>
                      <th>Odbiorca</th>
                      <th>Wiadomość</th>
                      <th>Data</th>
                    </tr>
                    <tr>
                      <td><a href='showUser.php?id=". $openMessage->getRecipient() . "'>".$userNameRecipient->getUsername()."</a></td>
                      <td>";

                      echo $openMessage->getMessage();

                      echo
                      "</td>
                      <td>$date</td>
                    </tr>
                    </table>
                    </div>
                    ";


                  }else{
                     echo "Błąd, nie ma takiej wiadomośći!";
                  }
              }
              ////////////////////////////// KONIEC READ ////////////////////////////////////

              ////////////////////////////// INBOX ////////////////////////////////////
              if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['inbox'])){
                  // wyswietlamy skrzynkę odbiorczą
                  $message = Message::loadAllRecipientMessagesByUserId($connection,$_SESSION['userId']);
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
                        $date = $date->format("Y-m-d");

                        $userNameSender = User::loadUserById($connection, $value->getSender());

                        $messageCut = substr($getMessage, 0, 40);
                        if (strlen($getMessage) >= 45) {
                            $messageCut .= "...";
                        }

                        // Wyswietlamy wiadomosci
                        echo "
                              <tr>
                              <td><a href='showUser.php?id=". $value->getSender() . "'>" . $userNameSender->getUsername() . "</a></td>
                              <td>
                              <a href='message.php?read=".$value->getId()."'>";
                              // jezeli wiadomosc nie jest odczytana to oznaczamy ja pogrubieniem
                              if ($value->getRead() == 0) {
                                echo "<b>";
                              }

                              echo $messageCut;

                              if ($value->getRead() == 0) {
                                echo "</b>";
                              }
                              echo
                              "</a><br></td>
                              <td>" . $date . "</td>
                            </tr>
                        ";

                    }
                    echo "</table></div>";
                  }else{
                    echo "<tr><td>Brak wiadomości.</td></tr>";
                  }
              }
              ////////////////////////////// KONIEC INBOX ////////////////////////////////////

              ////////////////////////////// OUTBOX ////////////////////////////////////
              if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['outbox'])){
                  // wyswietlamy skrzynkę odbiorczą
                  $message = Message::loadAllSendMessagesByUserId($connection,$_SESSION['userId']);

                  //print_r($message);
                  if ($message) {
                        echo "
                        <h2>Wysłane</h2>
                        <div class='table-responsive'>
                          <table class='table table-striped'>
                        <tr>
                          <th>Odbiorca</th>
                          <th>Wiadomość</th>
                          <th>Data</th>
                        </tr>
                        ";
                    foreach ($message as $key => $value) {
                        $getMessage = $value->getMessage();

                        // pobieramy informacje o uzytkowniku
                        $userNameRecipient = User::loadUserById($connection, $value->getRecipient());

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
                              <td><a href='showUser.php?id=". $value->getRecipient() . "'>".$userNameRecipient->getUsername()."</a></td>
                              <td><a href='message.php?read=".$value->getId()."'>".$messageCut."</a><br></td>
                              <td>" . $date . "</td>
                            </tr>
                        ";

                    }
                    echo "</table></div>";
                  }else{
                    echo "<tr><td>Brak wiadomości.</td></tr>";
                  }
              }
              ////////////////////////////// KONIEC OUTBOX ////////////////////////////////////
            ?>
    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
