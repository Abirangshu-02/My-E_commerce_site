<?php
    include('../admin/CRUD.php');
    session_start();
    $mail = $_SESSION['umail'];
    $resp = BuyProduct_delete($mail);
    if($resp)
        echo "Deleted";
?>