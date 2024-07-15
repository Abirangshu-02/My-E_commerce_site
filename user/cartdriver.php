<?php
    include('../admin/CRUD.php');
    session_start();
    if(isset($_SESSION['umail']))
    {
        $itmid = $_POST["itmid"];
        // $pos = $_GET["pos"];
        $res = add_to_cart($itmid,$_SESSION['umail']);
        $refer = $_SERVER['HTTP_REFERER'];
        // $loct = $refer.'#'.$pos;
        header('location:'.$refer);
    }
    else
    {
        $_SESSION['pre'] = $_SERVER['HTTP_REFERER'];
        echo "Failed";
    }
?>