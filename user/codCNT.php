<?php
    include('../admin/CRUD.php');
    session_start();            $countitms = 0;
    $mail = $_SESSION['umail'];
    $shipadd = $_POST['shp'];
    $phone = $_POST['mobile'];
    $notes = $_POST['nts'];
    $ttitms = $_POST['np'];
    $types = $_POST['tty'];
    $ttprice = $_POST['tamt'];
    $ptype = $_POST['mod'];
    
    $resp = orderbyCoD($mail, $shipadd, $ttitms, $ttprice, $ptype);

    $cart_items = cartitems($mail);
    while($data = mysqli_fetch_assoc($cart_items))
    {
        $p_info = showcart($data['pid']);
        $p_cost = mysqli_fetch_assoc($p_info);
        $ship_resp = shipittems($resp, $data['pid'], $p_cost['price'], $data['quantity'], $data['cartID']);
        $countitms++;
    }

    if($countitms == $types)
        echo "Order Placed Successfully";
    else
        echo "Order Not Placed";
?>