<?php 
require '../config.php';

if(isset($_POST['id'])){

    $id = intval($_POST['id']);
    $status = htmlspecialchars($_POST['status']);

    if($status === 'taken'){
        $checkStorage = $con->prepare("SELECT in_storage FROM ex_books WHERE book_id = (SELECT book_id FROM ex_readers WHERE reader_id = ?)");
        $checkStorage->bind_param("i", $id);
        $checkStorage->execute();
        $result = $checkStorage->get_result();
        $row = $result->fetch_assoc();

        if($row['in_storage'] === 'yes'){
            $dateTaken = date('Y-m-d H:i:s');
            $query = $con->prepare("UPDATE ex_readers SET status = ?, date_taken = ? WHERE reader_id = ?");
            $query->bind_param("ssi", $status, $dateTaken, $id);
        } else {
            echo $_SESSION['error'] = 'Grāmata nav pieejama!';
            http_response_code(400);
            exit;
        }
    }else if($status === 'returned'){
        $dateReturned = date('Y-m-d H:i:s');
        $checkIfTaken = $con->prepare("SELECT status FROM ex_readers WHERE reader_id = ?");
        $checkIfTaken->bind_param("i", $id);
        $checkIfTaken->execute();
        $reuslt = $checkIfTaken->get_result();
        $row = $reuslt->fetch_assoc();
        if($row['status'] !== 'taken'){
            echo $_SESSION['error'] = 'Grāmata nav izsniegta!';
            http_response_code(400);
            exit;
        }
        $query = $con->prepare("UPDATE ex_readers SET status = ?, date_returned = ?, last_book_taken = book_id, book_id = null WHERE reader_id = ?");
        $query->bind_param("ssi", $status, $dateReturned, $id);
    }else if($status === 'denied'){
        $checkIfTaken = $con->prepare("SELECT status FROM ex_readers WHERE reader_id = ?");
        $checkIfTaken->bind_param("i", $id);
        $checkIfTaken->execute();
        $reuslt = $checkIfTaken->get_result();
        $row = $reuslt->fetch_assoc();
        if($row['status'] === 'taken'){
           echo $_SESSION['error'] = 'Grāmata jau izsniegta!';
           http_response_code(400);
           exit;
        }
        $query = $con->prepare("UPDATE ex_readers SET status = ? WHERE reader_id = ?");
        $query->bind_param("si", $status, $id);
    }else{
        $query = $con->prepare("UPDATE ex_readers SET status = ? WHERE reader_id = ?");
        $query->bind_param("si", $status, $id);
    }
 

    if($query->execute()){
        echo 'Lasītājs redigets!';
        if ($status === 'taken') {
            $inStorage = 'no';
            $update_query = $con->prepare("UPDATE ex_books SET in_storage = ? WHERE book_id = (SELECT book_id FROM ex_readers WHERE reader_id = ?)");
            $update_query->bind_param("si",  $inStorage, $id);
            if($update_query->execute()){
                echo 'Date udated!';
            } else {
                echo 'Error : ' . $update_query->error;
            }
            $update_query->close();
        }
        if ($status === 'returned') {
            $inStorage = 'yes';
            $update_query = $con->prepare("UPDATE ex_books SET in_storage = ? WHERE book_id = (SELECT last_book_taken FROM ex_readers WHERE reader_id = ?)");
            $update_query->bind_param("si", $inStorage, $id);
            if($update_query->execute()){
                echo 'Dateupdated!';
            } else {
                echo 'Error : ' . $update_query->error;
            }
            $update_query->close();
        }
    } else {
        echo 'Kļūda!'. $query->error;
    }

    $query->close();
    $con->close();
}
