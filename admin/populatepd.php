<?php
    include('CRUD.php');
    $pid = $_POST['pid'];
    $resp = display_by_id($pid);
    $info = mysqli_fetch_assoc($resp);
    echo json_encode($info);
?>