<?php
session_start();


if(isset($_SESSION['logged']) && $_SESSION['logged'] = true){
    header('Location: http://localhost/coderslab/Twitter/public/admin/index.php');
}else{
    header('Location: http://localhost/coderslab/Twitter/public/admin/login.php');
}
