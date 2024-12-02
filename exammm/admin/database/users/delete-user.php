<?php
require '../config.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    $query = $con->prepare("UPDATE ex_users SET deleted = 'yes' WHERE user_id = ?");
    $query->bind_param("i", $id);

    if($query->execute()){
        echo 'Pieteikums dzēsts!';
    }else{
        echo 'Kļūda!'. $query->error;
    }

    $query->close();
    $con->close();

}