<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }
    $pageTitle = 'Lietotāji';
    $scriptName = 'users.js';

    
    if($_SESSION['role'] !== "admin"){
        header("Location: ./");
        exit;
    }
    require 'components/header.php';
?>
<section class="flex flex-col gap-8"> 
 
 <?php 
     $type = "Lietotāju";
     $buttonType = "newUserButton";
     require 'components/utils.php';
 ?>

 <div class="overflow-hidden container mx-auto rounded-md bg-white dark:bg-black px-4 py-8 text-black dark:text-white">
     <?php
     $tableHead = 'usersHead';
     $tableBody = 'usersBody';
     require 'components/table.php'; 
     ?>
 </div>
</section>

<?php
 $modalType = 'userModal';
 $formType = 'userForm';
 require 'components/modal.php';
 require 'components/footer.php';
?>
</body>
</html>