<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }

    $pageTitle = 'Grāmatas';

    require 'components/header.php';
?>


</body>
</html>