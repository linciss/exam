<?php 
require '../config.php';

if(isset($_POST['search'])){
    $input = '%' . htmlspecialchars($_POST['search']) . '%';    
    $query = $con->prepare("SELECT r.deleted, lb.title as lastBookTitle, r.last_book_taken, r.phone, r.reader_id, r.name, r.last_name, r.email, r.book_id, r.reg_date, r.status,b.title, r.date_taken, r.date_returned
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
        r.deleted = 'no' and (r.name like ? or r.last_name like ? or r.email like ?)
    ORDER BY 
        r.reader_id DESC");
    $query->bind_param("sss", $input, $input, $input);
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
        'book' => htmlspecialchars($row['title'] === null ? $row['status'] === 'returned' ? $row['lastBookTitle'] : "Nav" : $row['title']),
        'date' => htmlspecialchars($row['reg_date']),
        'status' => htmlspecialchars(
            $row['status'] === 'waiting' ? "Gaida" : 
            ($row['status'] === 'taken' ? "Apstiprināts" :
            ($row['status'] === 'returned' ? "Atdevis" : "Noraidīts"))
        ),
       'deadlineExceeded' => $row['status'] === 'taken' ? $deadlineExceeded : null,
    );
}

$query->close();

$jsonstring = json_encode($json);

echo $jsonstring;
   
}