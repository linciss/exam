<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // tailiwnd for custom stuff 
    tailwind.config = {
        content: [
        './**/*.php',
        './**/*.html',
        './**/*.js',
        './*.php',
        './**/**/*.php',
        './**/**/*.html',
        './**/**/*.js',
        ],
        theme: {
            extend: {
            colors: {
                nav: '#F0EAE5',
            },
            },
    },
    };
    </script>
    <link rel="stylesheet" href="../styles.css" />
  <script src="components/header.js" defer></script>
  <style>
      .show-menu {
          display: flex !important;
      }
    </style>
    <title><?php echo $pageTitle ?></title>
</head>
<body>
<header class="flex justify-between px-8 py-4 bg-nav">
        <a href="./" class="flex flex-row gap-2 items-center" id="logo-text">
            <i class="fa fa-server"></i> Bibliotech
        </a>
        <div class=" flex-row gap-4 items-center sm:flex hidden">
            <a href="./" class="<?php echo ($pageTitle == 'Sākums') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Sākums</a>
            <a href="./books.php" class="<?php echo ($pageTitle == 'Grāmatas') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Grāmatas</a>
            <a href="./readers.php" class="<?php echo ($pageTitle == 'Lasītāji') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lasītāji</a>
            <a href="./users.php" class="<?php echo ($pageTitle == 'Lietotāji') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lietotāji</a>
            <a href="logout.php" class="px-2 py-1 rounded-md border border-gray-500 flex flex-row gap-2 items-center"><?php echo $_SESSION['lincisExam']?><i class="fa-solid fa-power-off"></i></a>
        </div>
        <div class="sm:hidden hamburger cursor-pointer">
            <i class="fa-solid fa-bars"></i>
        </div>
            
    </header>
    <div class="flex-col gap-4 items-center fixed bg-nav h-screen w-full flex sm:hidden" id="menu">
    <a href="./" class="<?php echo ($pageTitle == 'Sākums') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Sākums</a>
            <a href="./books.php" class="<?php echo ($pageTitle == 'Grāmatas') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Grāmatas</a>
            <a href="./readers.php" class="<?php echo ($pageTitle == 'Lasītāji') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lasītāji</a>
            <a href="./users.php" class="<?php echo ($pageTitle == 'Lietotāji') ? 'bg-black ' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lietotāji</a>
            <a href="logout.php" class="px-2 py-1 rounded-md border border-gray-500 flex flex-row gap-2 items-center"><?php echo $_SESSION['lincisExam']?><i class="fa-solid fa-power-off"></i></a>
    </div>