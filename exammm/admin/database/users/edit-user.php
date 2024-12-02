<?php 
require '../config.php';

if(isset($_POST['id'])){

    $id = intval($_POST['id']);
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $password = htmlspecialchars($_POST['password']);


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if($password == '' || $password == null){
        $query = $con->prepare("UPDATE ex_users SET username = ?, name = ?, last_name = ?, email =?, role = ? WHERE user_id = ?");
        $query->bind_param("sssssi", $username, $name, $lastName, $email, $role, $id);
    }else{
        $query = $con->prepare("UPDATE ex_users SET username = ?, name = ?, last_name = ?, email =?, role = ?, password = ? WHERE user_id = ?");
        $query->bind_param("ssssssi", $username, $name, $lastName, $email, $role, $hashedPassword, $id);
    }
    


    if($query->execute()){
        echo 'Lietotajs redigets!';
    }else{
        echo 'Kļūda!'. $query->error;
    }


    $query->close();
    $con->close();

}