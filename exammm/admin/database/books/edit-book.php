<?php 
require '../config.php';

if(isset($_POST['id'])){

    $id = intval($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $genre = htmlspecialchars($_POST['genre']);
    $date = htmlspecialchars($_POST['release']);
    $description = htmlspecialchars($_POST['description']);
    $cover = $_POST['cover'];
    $inStorage = htmlspecialchars($_POST['inStorage']);

    $query = $con->prepare("UPDATE ex_books SET title = ?, author = ?, genre = ?, release_date = ?, cover_image = ?, description = ?, in_storage = ? WHERE book_id = ?");

    $query->bind_param("ssssbssi", $title, $author, $genre, $date, $cover, $description, $inStorage, $id);


    if($query->execute()){
        echo 'Pieteikums redigets!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}