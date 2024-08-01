<?php
    session_start();
    unset($_SESSION['umail']);
    unset($_SESSION['pre']);
    header('location:index.php');
?>