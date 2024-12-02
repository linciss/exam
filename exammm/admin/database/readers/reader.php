<?php 
require '../config.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $query = $con->prepare("SELECT lb.title as lastBookTitle, r.last_book_taken, r.phone, r.reader_id, r.name, r.last_name, r.email, r.book_id, r.reg_date, r.status,b.title, r.date_taken, r.date_returned
    FROM 
        ex_readers r
    LEFT JOIN 
        ex_books b 
    ON
        r.book_id = b.book_id
    LEFT JOIN 
        ex_books lb
    ON
        r.last_book_taken = lb.book_id
    WHERE
        r.reader_id = ?
    ORDER BY 
        r.reader_id DESC");
    $query->bind_param("i", $id);
    $query->execute();

    $result = $query->get_result();

    if(!$result){
        die('Invalid query: ' . mysqli_error());
    }

    
    $json = array();

   while($row = $result->fetch_assoc()){
    $json[] = array(
        'id' => htmlspecialchars($row['reader_id']),
        'name' => htmlspecialchars($row['name']),
        'lastName' => htmlspecialchars($row['last_name']),
        'email' => htmlspecialchars($row['email']),
        'date' => htmlspecialchars($row['reg_date']),
        'status' => htmlspecialchars($row['status']),
        'title' => htmlspecialchars($row['title'] === null ? $row['status'] === 'returned' ? $row['lastBookTitle'] : "Nav" : $row['title']),
        'phone' => htmlspecialchars($row['phone']),
        'dateTaken' => htmlspecialchars($row['date_taken']),
        'dateReturned' => htmlspecialchars($row['date_returned']),
    );
}

$query->close();
$con->close();

$jsonstring = json_encode($json[0]);

echo $jsonstring;
   
}