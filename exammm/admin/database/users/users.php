<?php 
require '../config.php';

$query = "SELECT * FROM ex_users WHERE deleted = 'no' ORDER BY user_id DESC";
$result = mysqli_query($con, $query);
 

if(!$result){
    die('Invalid query: ' . mysqli_error());
}

$json = array();


while($row = $result->fetch_assoc()){
    $json[] = array(
        'id' => htmlspecialchars($row['user_id']),
        'username' => htmlspecialchars($row['username']),
        'name' => htmlspecialchars($row['name']),
        'lastName' => htmlspecialchars($row['last_name']),
        'email' => htmlspecialchars($row['email']),
        'role' => htmlspecialchars($row['role']),
    );
}

$jsonstring = json_encode($json);

echo $jsonstring;