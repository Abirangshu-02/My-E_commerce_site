<?php
    include('../admin/CRUD.php');
    // session_start();
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
?>