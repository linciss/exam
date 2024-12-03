<?php
    require 'database/config.php';
    $username = $_SESSION['lincisExam'];
    $query = $con->prepare("SELECT * FROM ex_users WHERE username = ?");

    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    $user = $result->fetch_assoc();
   
    if($user['role'] === 'admin'){
        $_SESSION['role'] = 'admin';
    }else{
        $_SESSION['role'] = 'mod';
    }

    $query->close();
?>
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
        darkMode: 'class',
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
                body: '#F7F7F7',
                darkNav: '#1E1F1E',
                darkBody: '#121212',
            },
            screens:{
                'xs': '520px',
            }
            },
    },
    };
    </script>
    <link rel="stylesheet" href="../styles.css" />
  <script src="components/header.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
  <script src="scripts/<?php echo $scriptName ?>" defer></script>
  <?php 
     if($pageTitle === 'Sākums'){
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo "<script src='scripts/chartLogic.js' defer></script>";    
    }
  ?>
  <style>
      .show-menu {
          display: flex !important;
      }
    </style>
    <title><?php echo $pageTitle ?></title>
</head>
<body class="dark:bg-darkBody bg-body text-black dark:text-white flex flex-col min-h-screen">
    <div class="flex-grow">
    <header class="flex justify-between px-8 py-4 bg-nav dark:bg-darkNav border-b-2 border-gray-500 shadow-lg">
            <a href="./" class="flex flex-row gap-2 items-center text-2xl font-bold " id="logo-text">
                <i class="fa fa-server"></i> Bibliotēka
            </a>
            <div class=" flex-row gap-2 items-center sm:flex hidden">
                <a href="./" class="<?php echo ($pageTitle == 'Sākums') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500 hover:bg-orange-200 dark:hover:bg-zinc-700">Sākums</a>
                <a href="./books.php" class="<?php echo ($pageTitle == 'Grāmatas') ? 'bg-orange-200 dark:bg-zinc-700 ' : '' ?> px-2 py-1 rounded-md border border-gray-500 hover:bg-orange-200 dark:hover:bg-zinc-700">Grāmatas</a>
                <a href="./readers.php" class="<?php echo ($pageTitle == 'Lasītāji') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500 hover:bg-orange-200 dark:hover:bg-zinc-700">Lasītāji</a>
                <?php 
               echo $_SESSION['role'] === "admin" ? 
               "<a href='./users.php' class='" . 
               (($pageTitle == 'Lietotāji') ? 'bg-orange-200 dark:bg-zinc-700 ' : '') . 
               "px-2 py-1 rounded-md border border-gray-500 hover:bg-orange-200 dark:hover:bg-zinc-700'>Lietotāji</a>" 
               : '';
                ?>
                <a href="logout.php" class="px-2 py-1 rounded-md border border-gray-500 flex flex-row gap-2 items-center hover:bg-orange-200 dark:hover:bg-zinc-700"><?php echo $_SESSION['lincisExam']?><i class="fa-solid fa-power-off"></i></a>
                <a class="cursor-pointer px-2 py-1 border border-gray-500 rounded-md hover:bg-orange-200 dark:hover:bg-zinc-700" id="darkModeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></a>
            </div>
            <div class="sm:hidden flex flex-row gap-4 items-center"> 
            <div class=" hamburger cursor-pointer ">
                <i class="fa-solid fa-bars"></i>
            </div>
            <a class="cursor-pointer px-2 py-1 border border-gray-500 rounded-md " id="darkModeToggleMobile"><i class="fa-solid fa-moon" id="themeIconMobile"></i></a>
        </div>
        </header>
        <div class="flex-col py-20 gap-4 items-center fixed bg-nav h-screen w-full hidden dark:bg-darkBody bg-body text-black dark:text-white" id="menu">
        <a href="./" class="<?php echo ($pageTitle == 'Sākums') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500">Sākums</a>
                <a href="./books.php" class="<?php echo ($pageTitle == 'Grāmatas') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500">Grāmatas</a>
                <a href="./readers.php" class="<?php echo ($pageTitle == 'Lasītāji') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lasītāji</a>
                <a href="./users.php" class="<?php echo ($pageTitle == 'Lietotāji') ? 'bg-orange-200 dark:bg-zinc-700' : '' ?> px-2 py-1 rounded-md border border-gray-500">Lietotāji</a>
                <a href="logout.php" class="px-2 py-1 rounded-md border border-gray-500 flex flex-row gap-2 items-center"><?php echo $_SESSION['lincisExam']?><i class="fa-solid fa-power-off"></i></a>
        </div>