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

<div class="flex flex-row gap-2 justify-between items-center container mx-auto mt-5 md:px-0 px-8 text-black dark:text-white">
    <form class="flex flex-row gap-1">
        <input type="text" name="search" placeholder="Meklēt grāmatu" class="w-full xs:w-full border border-gray-500  px-2 py-1 rounded-md bg-white dark:bg-zinc-900">
        <button type="submit" class="px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md">Meklēt</button>
    </form>

    <button class="px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md ">
        <a href="add-book.php" class="" id="newBookButton">+ Pievienot grāmatu</a>
    </button>
</div>

<div class="overflow-hidden container mx-auto rounded-md bg-white dark:bg-black px-4 py-8 text-black dark:text-white">
    <?php
    $tableHead = 'booksHead';
    $tableBody = 'booksBody';
    require 'components/table.php'; 
     ?>
</div>

</section>



<?php
    require 'components/footer.php';
?>
</body>
</html>