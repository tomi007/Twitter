<?php

$max_rozmiar = 1024*1024*1024;
if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    if ($_FILES['plik']['size'] > $max_rozmiar) {
        echo 'Błąd! Plik jest za duży!';
    } else {
        echo 'Odebrano plik. Początkowa nazwa: '.$_FILES['plik']['name'];
        echo '<br/>';
        if (isset($_FILES['plik']['type'])) {
            echo 'Typ: '.$_FILES['plik']['type'].'<br/>';
        }
        move_uploaded_file($_FILES['plik']['tmp_name'],
        $_SERVER['DOCUMENT_ROOT'].'/coderslab/Twitter/public/admin/file/'.$_FILES['plik']['name']);
    }
} else {
   echo 'Błąd przy przesyłaniu danych!';
}
?>

<html>
 <body>
  <form method="POST" ENCTYPE="multipart/form-data">
   <input type="file" name="plik"/><br/>
   <input type="submit" value="Wyślij plik"/>
  </form>
 </body>
</html
