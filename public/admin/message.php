<?php
include_once '../bootstrap.php';
?>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <?php
        $username = $_SESSION['username'];
        echo "Witaj, <a href='#'>$username</a><br><br>";
        echo "<a href='#'>Nowa Wiadomość</a><br>";
        echo "<a href='#'>Skrzynka Odbiorcza (0)</a><br>";
        echo "<a href='#'>Wysłane</a><br>";
        echo "<a href='#'>Wyloguj się</a><br>";
      ?>
    </div>
    <div class="col-md-6">
    <h2>Wiadomości</h2>

    <div class="table-responsive">
      <table class="table">
            <?php
              // wyswietlamy skrzynkę odbiorczą
              $message = Message::loadAllSendMessagesByUserId($connection,$_SESSION['userId']);
              //print_r($message);

                foreach ($message as $key => $value) {
                    // $getMessage = $value->getMessage();



                    $getMessage = $value->getMessage();
                    $messageCut = substr($getMessage, 0, 50);
                    if (strlen($getMessage) >= 50) {
                        $messageCut .= "...";
                    }


                    echo "
                        <tr>
                        	<td><a href='message.php?read=1'><b>".$messageCut."</b></a><br></td>
                        </tr>
                    ";

                }
              //$message->getMessage();

            ?>

      </table>
    </div>

    </div>
    <div class="col-md-3">[miejsce na profil]</div>
  </div>
</div>
