<?php
    include('../admin/CRUD.php');
    session_start();
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'cart.php')
    {
        $cartid = $_POST['cartid'];
        $resp = removecart($cartid);
        echo $resp;
    }
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'Buycheckout.php')
    {
        $mail = $_SESSION['umail'];
        $resp = BuyProduct_delete($mail);
        if($resp)
            echo "Deleted";
    }
?>