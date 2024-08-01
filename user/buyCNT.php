<?php
    include('../admin/CRUD.php');
    session_start();
    if(isset($_SESSION['umail']))
    {
        $pid = $_POST["pid"];
        $res = buyinsert($pid,$_SESSION['umail']);
        header('location:Buycheckout.php');
    }
    else
    {
        $_SESSION['pre'] = $_SERVER['HTTP_REFERER'];
        echo "Failed";
    }
?>