<?php
require '../config.php';
if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    $checkQuery = $con->prepare("SELECT * FROM ex_readers WHERE reader_id = ?");
    $checkQuery->bind_param("i", $id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();
    $checkRow = $checkResult->fetch_assoc();
    if($checkRow['status'] === 'taken'){
        echo $_SESSION['errorDelete'] = 'Šo lasītāju nevar dzēst!';
        exit();
    }

    $query = $con->prepare("DELETE FROM ex_readers WHERE reader_id = ?");
    $query->bind_param("i", $id);

    if($query->execute()){
        echo 'lasitjas dzēsts!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}