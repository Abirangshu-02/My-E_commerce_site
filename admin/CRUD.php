<?php
    include('../phpmailer/PHPMailerAutoload.php');

    function connect()
    {
        $conn = mysqli_connect("localhost","root","","shopping");
        if($conn)
            return $conn;
        else
            echo "Error Connecting to DB";
    }
    // ============================================ Admin ===========================================================
    function adminlogin($data) //admin login
    {
        $con = connect();
        $mail = $data['email'];
        $pkey = $data['pssd'];
        
        $sql = "select * from admin where email='$mail' and password='$pkey'";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function infock($data)  //info retrive
    {
        $con = connect();
        if(is_array($data))
        {
            $email = $data['email'];
            $sql = "select * from admin where email='$email'";
            $resp = mysqli_query($con,$sql);
        }
        else
        {
            $sql = "select * from admin where email='$data'";
            $resp = mysqli_query($con,$sql);
        }
        return $resp;
    }
    function akyretrive($data) //password retrive sent
    {
        $rcv = infock($data);
        $rec = mysqli_num_rows($rcv);
        if($rec > 0)
        {
            $rt = mysqli_fetch_assoc($rcv);

            $mail = new phpmailer;
            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            $mail->Username = 'abirangshu.gc2@gmail.com';
            $mail->Password = 'rjhfogthqdvkdedh';

            $mail->setFrom('abirangshu.gc2@gmail.com','Fruitables');
            $mail->addAddress($data['email']);
            $mail->addReplyTo('abirangshu.gc2@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Password Retrival Mail';
            $message = "";
            $message = $message."Hi, admin <b>".$rt['name']."</b>.<br>The lost password to your account is <i>".$rt['password']."</i>";
            $mail->Body = $message;

            if($mail->send())
                return 1;
            else
                return 0;
        }
        else
            return -1;
    }
    function addProduct($data)  //add Product
    {
        $con = connect();
        $cat = $data['type'];
        $nm = $data['iname'];
        $pr = $data['iprice'];
        $stk = $data['istock'];

        $dir = "productimg/";
        $ppath = $dir . basename($_FILES["ipic"]["name"]);
        $fmt = strtolower(pathinfo($ppath,PATHINFO_EXTENSION));
        if($fmt=="jpg" || $fmt=="jpeg" || $fmt=="png")
        {
            if(!file_exists($ppath))
            {
                if(move_uploaded_file($_FILES["ipic"]["tmp_name"],$ppath))
                {
                    $sql = "insert into products(category,name,price,stock,image) values('$cat','$nm','$pr','$stk','$ppath')";
                    $res = mysqli_query($con,$sql);
                    return $res;
                }
                else
                    return "Not Uploaded";
            }
            else
                return "image Already Exists";
        }
        else
            return "unsupported Format";
    }
    function displayProduct()
    {
        $con=connect();
        $sql = "select * from products";
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function displayProductWithLimit($index)
    {
        $con=connect();
        $sql = "select * from products limit 3 offset ".$index;
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function display_by_type($type)
    {
        $con=connect();
        $sql = "select * from products where category='$type'";
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function PDupdate($data)
    {
        $con = connect();
        $pid = $data['iname'];
        $catp = $data['utype'];
        $nm = $data['uname'];
        $pr = $data['uprice'];
        $stk = $data['ustock'];

        if(!empty($_FILES['upic']['name']))
        {
            $dir = "productimg/";
            $ppath = $dir . basename($_FILES["upic"]["name"]);
            $fmt = strtolower(pathinfo($ppath,PATHINFO_EXTENSION));
            if($fmt=="jpg" || $fmt=="jpeg" || $fmt=="png")
            {
                if(!file_exists($ppath))
                {
                    if(move_uploaded_file($_FILES["upic"]["tmp_name"], $ppath))
                    {
                        $rp1 = display_by_id($pid);
                        $rp2 = mysqli_fetch_assoc($rp1);
                        $path = $rp2['image'];
                        unlink($path);

                        $sql = "update products set category='$catp', name='$nm', price='$pr', stock='$stk', image='$ppath' where product_id='$pid'";
                        $res = mysqli_query($con,$sql);
                        return 1;
                    }
                    else
                        return "Not Uploaded";
                }
                else
                    return "image Already Exists";
            }
            else
                return "unsupported Format";
        }
        else
        {
            $sql = "update products set category='$catp', name='$nm', price='$pr', stock='$stk' where product_id='$pid'";
            $res = mysqli_query($con,$sql);
            return 1;
        }
    }
    function delPd($id) // delete data
    {
        $con = connect();
        $rp1 = display_by_id($id);
        $rp2 = mysqli_fetch_assoc($rp1);
        $path = $rp2['image'];

        $sql = "delete from products where product_id='$id'";
        $resp = mysqli_query($con, $sql);
        if($resp == 1)
            unlink($path);
        
        return $resp;
    }
    function display_by_id($id)    //query to diplay data
    {
        $con = connect();
        $sql = "select * from products where product_id = '$id'";
        $resp = mysqli_query($con, $sql);
        return $resp;
    }
    function displayUsers()
    {
        $con=connect();
        $sql = "select * from users";
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function diaplaybyname($data)
    {
        $con=connect();
        $sql = "select * from users where uname = '$data'";
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function displayOrders()
    {
        $con=connect();
        $sql = "select * from orders";
        $res = mysqli_query($con,$sql);
        return $res;
    }
    function showbyname($data)
    {
        $con = connect();
        $sql = "select * from users where uname = '$data'";
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res) > 0)
        {
            $rpx = mysqli_fetch_assoc($res);
            $mail = $rpx['email'];
            $sqlq = "select * from orders where email = '$mail'";
            $resp = mysqli_query($con,$sqlq);
        }
        return $resp;
    }
    // ===================================================================USER===================================================
    function usersingup($data) // user sign up
    {
        $con = connect();
        $nm = $data['uname'];
        $ph = $data['mobile'];
        $mail = $data['mail'];
        $pwd = $data['pkey'];

        $sql = "insert into users(uname,contact,email,password) values('$nm','$ph','$mail','$pwd')";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function userlogin($data) //user login
    {
        $con = connect();
        $mail = $data['mail'];
        $pkey = $data['vry'];
        
        $sql = "select * from users where email='$mail' and password='$pkey'";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function userinfo($data)
    {
        $con = connect();
        if(is_array($data))
        {
            $email = $data['email'];
            $sql = "select * from users where email='$email'";
            $resp = mysqli_query($con,$sql);
        }
        else
        {
            $sql = "select * from users where email='$data'";
            $resp = mysqli_query($con,$sql);
        }
        return $resp;
    }
    function ukyretrive($data) // user password retrive
    {
        $rcv = userinfo($data);
        $rec = mysqli_num_rows($rcv);
        if($rec > 0)
        {
            $rt = mysqli_fetch_assoc($rcv);

            $mail = new phpmailer;
            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            $mail->Username = 'abirangshu.gc2@gmail.com';
            $mail->Password = 'rjhfogthqdvkdedh';

            $mail->setFrom('abirangshu.gc2@gmail.com','Fruitables');
            $mail->addAddress($data['email']);
            $mail->addReplyTo('abirangshu.gc2@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Password Retrival Mail';
            $message = "";
            $message = $message."Hi, <b>".$rt['uname']."</b>.<br>The lost password to your account is <i>".$rt['password']."</i>";
            $mail->Body = $message;

            if($mail->send())
                return 1;
            else
                return 0;
        }
        else
            return -1;
    }
    function update_user_info($data)
    {
        $conn = connect();
        $un = $data['uname'];
        $uc = $data["ucontact"];
        $umail = $data['uemail'];
        $upk = $data["upkey"];
        $udob = $data["Dob"];
        $uadd = $data["location"];
        
        $sql = "update users set uname='$un', contact='$uc', password='$upk', DoB='$udob', address_zip='$uadd' where email='$umail'";
        $rsp = mysqli_query($conn,$sql);
        return 1;

    }
    function add_to_cart($pid,$mail)
    {
        $con = connect();
        $check = duplicate_check($pid,$mail);
        if($check == 1)
            return -1;
        else
        {
            $sql = "insert into carts(product_id, usermail, quantity) values('$pid','$mail','1')";
            $res = mysqli_query($con,$sql);
            return $res;
        }
    }
    function duplicate_check($id,$mail)
    {
        $con = connect();
        $sql = "select * from carts where product_id='$id' and usermail='$mail'";
        $resp = mysqli_query($con,$sql);
        $rec = mysqli_num_rows($resp);
        if($rec > 0)
            return 1;
        else
            return 0;
    }
    function cartitems($mail)
    {
        $con = connect();
        $sql = "select * from carts where usermail='$mail'";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function showitems($pid)
    {
        $con = connect();
        $sql = "select * from products where product_id='$pid'";
        $response = mysqli_query($con,$sql);
        return $response;
    }
    function removecart($cid)
    {
        $con = connect();
        $sql = "delete from carts where cartID='$cid'";
        $response = mysqli_query($con,$sql);
        return $response;
    }
    function quantitychange($cid,$st)
    {
        $con = connect();
        $sql = "update carts set quantity=quantity+'$st' where cartID='$cid'";
        $response = mysqli_query($con,$sql);
        return $response;
    }
    function buyinsert($pdid,$mail)
    {
        $con = connect();
        $check = duplicate_vfy($pid,$mail);
        if($check == 1)
            return -1;
        else
        {
            $sqlI = "insert into buynow(product_id,email,quantity) values('$pdid','$mail','1')";
            $resB = mysqli_query($con,$sqlI);
            return $resB;
        }
    }
    function duplicate_vfy($id,$mail)
    {
        $con = connect();
        $sql = "select * from buynow where product_id='$id' and email='$mail'";
        $resp = mysqli_query($con,$sql);
        $rec = mysqli_num_rows($resp);
        if($rec > 0)
            return 1;
        else
            return 0;
    }
    function buyitems($mail)
    {
        $con = connect();
        $sql = "select * from buynow where email='$mail'";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function Buyquantitychange($mail,$st)
    {
        $con = connect();
        $sql = "update buynow set quantity=quantity+'$st' where email='$mail'";
        $response = mysqli_query($con,$sql);
        return $response;
    }
    function BuyProduct_delete($mail)
    {
        $con = connect();
        $sql = "delete from buynow where email='$mail'";
        $resp = mysqli_query($con,$sql);
        return $resp;
    }
    function insReview($data)
    {
        $con = connect();
        $nm = $data['qname'];
        $em = $data['qemail'];
        $mg = $data['msg'];
        $sql = "insert into reviews(name,email,message) values('$nm','$em','$mg')";
        $rsp = mysqli_query($con,$sql);
        return $rsp;
    }
    function reviewMail($data) // user password retrive
    {
        $nm = $data['qname'];
        $em = $data['qemail'];

        $mail = new phpmailer;
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'abirangshu.gc2@gmail.com';
        $mail->Password = 'rjhfogthqdvkdedh';

        $mail->setFrom('abirangshu.gc2@gmail.com','Fruitables');
        $mail->addAddress($em);
        $mail->addReplyTo('abirangshu.gc2@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Query Mail';
        $message = "";
        $message = $message."Hi, <b>".$nm."</b>.<br>Thank you for contacting us.<br>We will get back to you soon !! <i>";
        $mail->Body = $message;

        if($mail->send())
            return 1;
        else
            return 0;
    }
    function orderbyCoD($mail, $shipadd, $ttitms, $ttprice, $ptype)
    {
        $con = connect();
        $sql = "insert into orders(email,ship_address_zip,no_of_products,total_amount,paymode,status) values('$mail', '$shipadd', '$ttitms', '$ttprice', '$ptype', 'Pending')";
        $responseCD = mysqli_query($con,$sql);
        if($responseCD)
        {
            $oid = mysqli_insert_id($con);
            return $oid;
        }
    }
    function orderbyPaypal($mail, $shipadd, $ttitms, $ttprice, $ptype, $pyid)
    {
        $con = connect();
        $sql = "insert into orders(email,ship_address_zip,no_of_products,total_amount,paymode,payid,status) values('$mail', '$shipadd', '$ttitms', '$ttprice', '$ptype', '$pyid', 'Paid')";
        $responsePP = mysqli_query($con,$sql);
        if($responsePP)
        {
            $oid = mysqli_insert_id($con);
            return $oid;
        }
    }
    function shipittems_CART($oid, $pids, $c_price, $qtys, $cid)
    {
        $con = connect();
        $sql = "insert into shipping(order_id,product_id,price_at_order,quantity) values('$oid','$pids','$c_price','$qtys')";
        $response2 = mysqli_query($con,$sql);
        if($response2)
        {
            $sqlD = "delete from carts where cartID='$cid'";
            mysqli_query($con,$sqlD);
        }
        return $response2;
    }
    function shipittems_BUY($oid, $pids, $c_price, $qtys, $mail)
    {
        $con = connect();
        $sql = "insert into shipping(order_id,product_id,price_at_order,quantity) values('$oid','$pids','$c_price','$qtys')";
        $response2 = mysqli_query($con,$sql);
        if($response2)
        {
            $sqlD = "delete from buynow where email='$mail'";
            mysqli_query($con,$sqlD);
        }
        return $response2;
    }
?>