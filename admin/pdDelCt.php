<?php
    include('CRUD.php');
    $id = $_POST['pid'];
    $responce = delPd($id);
    if($responce == 1)
        echo "Success";
    else
        echo "Failed";
?>