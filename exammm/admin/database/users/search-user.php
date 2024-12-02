<?php 
require '../config.php';

if(isset($_POST['search'])){
    $input = '%' . htmlspecialchars($_POST['search']) . '%';    
    $query = $con->prepare("SELECT * FROM ex_users where username like ? or name like ? or last_name like ? ORDER BY user_id DESC");
    $query->bind_param("sss", $input, $input, $input);
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
    );
}
}

$query->close();

$jsonstring = json_encode($json);

echo $jsonstring;
   
