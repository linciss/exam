<?php
require '../config.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    $query = $con->prepare("DELETE FROM ex_books WHERE book_id = ?");
    $query->bind_param("i", $id);

    if($query->execute()){
        echo 'Pieteikums dzēsts!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}