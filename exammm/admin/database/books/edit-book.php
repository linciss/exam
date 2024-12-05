<?php 
require '../config.php';

if(isset($_POST['id'])){

    $id = intval($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $genre = htmlspecialchars($_POST['genre']);
    $date = htmlspecialchars($_POST['release']);
    $description = htmlspecialchars($_POST['description']);
    $cover = isset($_FILES['cover']) ? $_FILES['cover'] : null;
    $coverData = $cover ? file_get_contents($cover['tmp_name']) : null; 

    $inStorage = htmlspecialchars($_POST['inStorage']);

    $checkQuery = $con->prepare("SELECT * FROM ex_books WHERE book_id = ?");
    $checkQuery->bind_param("i", $id);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $checkQuery->close();
    $result = $result->fetch_assoc();
    if(!$result){
        die('Invalid query: ' . mysqli_error());
    }
    if($result['in_storage'] !== $inStorage){
        $query = $con->prepare("SELECT * FROM ex_readers WHERE book_id = ? AND status = 'taken'");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        $query->close();
        $result = $result->fetch_assoc();
        if($result){
            echo $_SESSION['error'] = 'Grāmata nav atgriezta!';
            http_response_code(400);
            exit;
        }else{
            $query = $con->prepare("UPDATE ex_readers SET status = 'atgriezts' WHERE book_id = ?");
            $query->bind_param("i", $id);
            $query->execute();
            $query->close();
        }
       
    }

    if($cover['size'] === 0 || $cover === null || $cover === '' || $coverData === null || empty($coverData)){
        $coverData = $result['cover_image'];
    }
    $query = $con->prepare("UPDATE ex_books SET title = ?, author = ?, genre = ?, release_date = ?, cover_image = ?, description = ?, in_storage = ? WHERE book_id = ?");
    $query->bind_param("sssssssi", $title, $author, $genre, $date, $coverData, $description, $inStorage, $id);


    if($query->execute()){
        echo 'GRamat  redigets!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}