<?php
    include('../admin/CRUD.php');
    session_start();
    $mail = $_SESSION['umail'];
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'cart.php')
    {
        $cartid = $_POST['cartid'];
        $state = $_POST['state'];
        if($state == -1)
        {
            $resp = quantitychange($cartid,$state);
            echo "decreased";
        }
        if($state == 1)
        {
            $resp = quantitychange($cartid,$state);
            echo "increased";
        }
    }
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'Buycheckout.php')
    {
        $state = $_POST['state'];
        if($state == -1)
        {
            $resp = Buyquantitychange($mail,$state);
            echo "decreased";
        }
        if($state == 1)
        {
            $resp = Buyquantitychange($mail,$state);
            echo "increased";
        }
    }
?>