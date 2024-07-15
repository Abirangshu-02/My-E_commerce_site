<?php
    include('../admin/CRUD.php');
    $cartid = $_POST['cartid'];
    $resp = removecart($cartid);
    echo $resp;
?>