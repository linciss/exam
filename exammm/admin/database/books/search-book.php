<?php 
require '../config.php';

if(isset($_POST['search'])){
    $input = '%' . htmlspecialchars($_POST['search']) . '%';    
    $query = $con->prepare("SELECT * FROM ex_books where title like ? or author like ? or genre like ?  ORDER BY  book_id DESC");
    $query->bind_param("sss", $input, $input, $input);
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
        'inStorage' => htmlspecialchars($row['in_storage']) === 'yes' ? "Jā" : "Nē",
        'genre' => htmlspecialchars($row['genre']),
    );
}

$query->close();

$jsonstring = json_encode($json);

echo $jsonstring;
   
}