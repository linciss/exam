<?php
    if(isset($_POST['login'])){
        require 'con_db.php';
        session_start();

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $query = $con->prepare("SELECT * FROM Ex_users WHERE username = ?");

        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();

        $user = $result->fetch_assoc();
        if($user && password_verify($password, $user['password'])){
            echo $_SESSION['lincisExam'] = $user['username'];
        }else{
            echo $_SESSION['pazinojumslinards'] = 'Nepareizs lietotājvārds vai parole!';
        }

        header("Location: ../");


        $query->close();
        $con->close();
    }
?>