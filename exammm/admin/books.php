<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }

    $pageTitle = 'Grāmatas';

    require 'components/header.php';
?>

<?php
    require 'components/footer.php';
?>
</body>
</html>