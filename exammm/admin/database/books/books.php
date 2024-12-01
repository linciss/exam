<?php 
require '../config.php';

$query = "SELECT * FROM ex_books ORDER BY book_id DESC";
$result = mysqli_query($con, $query);
 

if(!$result){
    die('Invalid query: ' . mysqli_error());
}

$json = array();


while($row = $result->fetch_assoc()){
    $json[] = array(
        'id' => htmlspecialchars($row['book_id']),
        'name' => htmlspecialchars($row['name']),
        'author' => htmlspecialchars($row['author']),
        'releaseDate' => htmlspecialchars($row['release_date']),
        'inStorage' => htmlspecialchars($row['in_storage']) === 'yes' ? "Jā" : "Nē",
        'genre' => htmlspecialchars($row['genre']),
    );
}

$jsonstring = json_encode($json);

echo $jsonstring;