<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require '../config.php';
    session_start();
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $genre = htmlspecialchars($_POST['genre']);
    $date = htmlspecialchars($_POST['release']);
    $description = htmlspecialchars($_POST['description']);
    $cover = $_FILES['cover'];
    $coverData = file_get_contents($cover['tmp_name']); 



    if(empty($title) || empty($author) || empty($genre) || empty($date) || empty($description) || empty($cover)){
            echo $_SESSION['error'] = 'Lūdzu aizpildiet visus laukus!';
            http_response_code(400);
            exit;
        }

    $query = $con->prepare("INSERT INTO ex_books (title, author, genre, release_date, cover_image, description) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $title, $author, $genre, $date, $coverData, $description);
    


    if($query->execute()){
        echo $_SESSION['success'] = 'GHramnata pievienošan!';
    }else{
       echo $_SESSION['error'] = 'Pieteikuma pievienošana neizdevās!';
    }

    header("Location: ../../books.php");
    $query->close();
    $con->close();

}
?>