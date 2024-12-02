<?php
require '../config.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    $query = $con->prepare("UPDATE ex_readers set deleted = 'yes' WHERE reader_id = ?");
    $query->bind_param("i", $id);

    if($query->execute()){
        echo 'lasitjas dzēsts!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}