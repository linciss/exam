<?php 
if(isset($_POST['id'])){
    require '../config.php';
    session_start();
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $genre = htmlspecialchars($_POST['genre']);
    $date = htmlspecialchars($_POST['release']);
    $description = htmlspecialchars($_POST['description']);
    $cover = $_POST['cover'];

    if(empty($title) || empty($author) || empty($genre) || empty($date) || empty($description)){
        echo $_SESSION['error'] = 'Lūdzu aizpildiet visus laukus!';
        http_response_code(400);
        exit;
    }

    $query = $con->prepare("INSERT INTO ex_books (title, author, genre, release_date, cover_image, description) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssbs", $title, $author, $genre, $date, $cover, $description);
    


    if($query->execute()){
        echo 'Pieteikums pievienots!';
    }else{
       echo $_SESSION['error'] = 'Pieteikuma pievienošana neizdevās!';
    }

    header("Location: ../../books.php");
    $query->close();
    $con->close();

}
?>