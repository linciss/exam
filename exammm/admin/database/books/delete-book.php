<?php
require '../config.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    $checkQuery = $con->prepare("SELECT * FROM ex_books WHERE book_id = ?");
    $checkQuery->bind_param("i", $id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();
    $checkRow = $checkResult->fetch_assoc();
    if($checkRow['in_storage'] === 'no'){
        echo $_SESSION['errorDelete'] = 'Šo grāmatu nevar dzēst!';
        exit();
    }

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