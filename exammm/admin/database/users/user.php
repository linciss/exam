<?php 
require '../config.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $query = $con->prepare("SELECT * from ex_users WHERE user_id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    $result = $query->get_result();

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
        'deleted' => htmlspecialchars($row['deleted'] === 'yes' ? "Jā" : "Nē"),
    );
}

$query->close();
$con->close();

$jsonstring = json_encode($json[0]);

echo $jsonstring;
   
}