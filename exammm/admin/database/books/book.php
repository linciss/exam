<?php 
require '../config.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $query = $con->prepare("SELECT * from ex_books WHERE book_id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    $result = $query->get_result();

    if(!$result){
        die('Invalid query: ' . mysqli_error());
    }

    
    $json = array();

   while($row = $result->fetch_assoc()){
    $json[] = array(
        'id' => htmlspecialchars($row['book_id']),
        'title' => htmlspecialchars($row['title']),
        'author' => htmlspecialchars($row['author']),
        'releaseDate' => htmlspecialchars($row['release_date']),
        'inStorage' => htmlspecialchars($row['in_storage']),
        'genre' => htmlspecialchars($row['genre']),
        'description' => htmlspecialchars($row['description']),
    );
}

$query->close();
$con->close();

$jsonstring = json_encode($json[0]);

echo $jsonstring;
   
}