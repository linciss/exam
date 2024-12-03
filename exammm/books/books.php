<?php 
require '../admin/database/config.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 8;
$offset = ($page - 1) * $itemsPerPage;


$totalQuery = "SELECT COUNT(*) as total FROM ex_books";
$totalResult = mysqli_query($con, $totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalItems = $totalRow['total'];


$query = "SELECT * FROM ex_books ORDER BY book_id DESC LIMIT $itemsPerPage OFFSET $offset";
$result = mysqli_query($con, $query);


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
        'cover' => $row['cover_image'] === null ? null : base64_encode($row['cover_image']),
    );
}

$response = array(
    'books' => $json,
    'totalItems' => $totalItems,
    'itemsPerPage' => $itemsPerPage,
    'currentPage' => $page,
);

echo json_encode($response);