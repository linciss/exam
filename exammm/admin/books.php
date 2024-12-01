<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }

    $pageTitle = 'Grāmatas';
    $scriptName = 'books.js';

    require 'components/header.php';
?>

<section class="flex flex-col gap-8"> 
 
    <?php 
        $type = "Grāmatu";
        $buttonType = "newBookButton";

        require 'components/utils.php';
    ?>

    <div class="overflow-hidden container mx-auto rounded-md bg-white dark:bg-black px-4 py-8 text-black dark:text-white">
        <?php
        $tableHead = 'booksHead';
        $tableBody = 'booksBody';
        require 'components/table.php'; 
        ?>
    </div>
</section>

<?php
    $modalType = 'bookModal';
    $formType = 'bookForm';
    require 'components/modal.php';
    require 'components/footer.php';
?>
</body>
</html>