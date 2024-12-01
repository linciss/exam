<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }

    $pageTitle = 'Lasītāji';

    require 'components/header.php';
?>


</body>
</html>