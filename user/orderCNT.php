<?php
    include('../admin/CRUD.php');
    session_start();        $countitms=0;
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'checkout.php')
    {
        $mail = $_SESSION['umail'];
        $shipadd = $_POST['shp'];
        $phone = $_POST['mobile'];
        $notes = $_POST['nts'];
        
        $ttitms = $_POST['np'];
        $types = $_POST['tty'];
        $ttprice = $_POST['tamt'];
        $ptype = $_POST['mod'];

        if($ptype == "cod")
        {
            $resp = orderbyCoD($mail, $shipadd, $ttitms, $ttprice, $ptype);

            $cart_items = cartitems($mail);
            while($data = mysqli_fetch_assoc($cart_items))
            {
                $p_info = showitems($data['pid']);
                $p_cost = mysqli_fetch_assoc($p_info);
                $ship_resp = shipittems_CART($resp, $data['pid'], $p_cost['price'], $data['quantity'], $data['cartID']);
                $countitms++;
            }
            if($countitms == $types)
                echo "Order Placed Successfully";
            else
                echo "Order Not Placed";
        }
        else
        {
            $pyid = $_POST['tid'];
            $resp = orderbyPaypal($mail, $shipadd, $ttitms, $ttprice, $ptype, $pyid);

            $cart_items = cartitems($mail);
            while($data = mysqli_fetch_assoc($cart_items))
            {
                $p_info = showitems($data['pid']);
                $p_cost = mysqli_fetch_assoc($p_info);
                $ship_resp = shipittems_CART($resp, $data['pid'], $p_cost['price'], $data['quantity'], $data['cartID']);
                $countitms++;
            }
            if($countitms == $types)
                echo "Order Placed Successfully";
            else
                echo "Order Not Placed";
        }
    }
    if(isset($_SERVER['HTTP_REFERER']) && basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH)) == 'Buycheckout.php')
    {
        $mail = $_SESSION['umail'];
        $shipadd = $_POST['shp'];
        $phone = $_POST['mobile'];
        $notes = $_POST['nts'];

        $ttitms = $_POST['np'];
        $ttprice = $_POST['tamt'];
        $ptype = $_POST['mod'];

        if($ptype == "cod")
        {
            $resp = orderbyCoD($mail, $shipadd, $ttitms, $ttprice, $ptype);

            $byitems = buyitems($mail);
            $data = mysqli_fetch_assoc($byitems);
            $p_info = showitems($data['pid']);
            $p_cost = mysqli_fetch_assoc($p_info);
            $ship_resp = shipittems_BUY($resp, $data['pid'], $p_cost['price'], $data['quantity'], $mail);

            if($ship_resp)
                echo "Order Placed Successfully";
            else
                echo "Order Not Placed";
        }
        else
        {
            $pyid = $_POST['tid'];
            $resp = orderbyPaypal($mail, $shipadd, $ttitms, $ttprice, $ptype, $pyid);

            $byitems = buyitems($mail);
            $data = mysqli_fetch_assoc($byitems);
            $p_info = showitems($data['pid']);
            $p_cost = mysqli_fetch_assoc($p_info);
            $ship_resp = shipittems_BUY($resp, $data['pid'], $p_cost['price'], $data['quantity'], $mail);
            
            if($ship_resp)
                echo "Order Placed Successfully";
            else
                echo "Order Not Placed";
        }
    }
?>