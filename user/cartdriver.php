<?php
    include('../admin/CRUD.php');
    session_start();
    if(isset($_SESSION['umail']))
    {
        $itmid = $_POST["itmid"];
        $res = add_to_cart($itmid,$_SESSION['umail']);
        $refer = $_SERVER['HTTP_REFERER'];
        header('location:'.$refer);
    }
    else
    {
        $_SESSION['pre'] = $_SERVER['HTTP_REFERER'];
        echo "Failed";
    }
?>