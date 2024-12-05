<?php
    include('../admin/CRUD.php');
    $uid = $_POST['usermail'];
    $resp = userinfo($uid);
    $info = mysqli_fetch_assoc($resp);
    echo json_encode($info);
?>