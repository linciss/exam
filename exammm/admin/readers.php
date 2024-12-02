<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }
    $pageTitle = 'Lasītāji';
    $scriptName = 'readers.js';


    require 'components/header.php';
?>
<section class="flex flex-col gap-8"> 
 
 <?php 
     $type = "Lasītāju";
     $buttonType = "newReaderButton";
     require 'components/utils.php';
 ?>

 <div class="overflow-hidden container mx-auto rounded-md bg-white dark:bg-black px-4 py-8 text-black dark:text-white">
     <?php
     $tableHead = 'readersHead';
     $tableBody = 'readersBody';
     require 'components/table.php'; 
     ?>
 </div>
</section>

<?php
 $modalType = 'readerModal';
 $formType = 'readerForm';
 require 'components/modal.php';
 require 'components/footer.php';
?>
</body>
</html>