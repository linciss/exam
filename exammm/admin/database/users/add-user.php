<?php 
if(isset($_POST['id'])){
    require '../config.php';
    session_start();
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $password = htmlspecialchars($_POST['password']);
    
    $userNameCheck = $con->prepare("SELECT * FROM ex_users where username = ?");
    $userNameCheck->bind_param('s', $username);
    $userNameCheck->execute();
    $result = $userNameCheck->get_result();

    if($result->num_rows > 0){
        echo $_SESSION['error'] = 'Lietotājvārds jau ir aizņemts!';
        http_response_code(400);
        exit;
    }

    if(empty($username) || empty($name) || empty($lastName) || empty($email) || empty($role) || empty($password)){
        echo $_SESSION['error'] = 'Lūdzu aizpildiet visus laukus!';
        http_response_code(400);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = $con->prepare("INSERT INTO ex_users (username, name, last_name, email, role, password) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $username, $name, $lastName, $email, $role, $hashedPassword);
    
    if($query->execute()){
        echo 'Pieteikums pievienots!';
    }else{
       echo $_SESSION['error'] = 'Pieteikuma pievienošana neizdevās!';
    }

    header("Location: ../../users.php");
    $query->close();
    $con->close();

}
?>