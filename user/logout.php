<?php
    session_start();
    unset($_SESSION['umail']);
    unset($_SESSION['pre']);
    unset($_SESSION['productids']);
    header('location:index.php');
?>