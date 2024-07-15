<?php
    session_start();
    unset($_SESSION['admail']);
    header('location:index.php');
?>