<?php
    session_start();
    if(isset($_SESSION['lincisExam'])){
        header("Location: index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT atbalsts - autorizācija</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>    
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
                modal: '#F0EAE5',
                body: '#F7F7F7',
                darkModal: '#1E1F1E',
                darkBody: '#121212',
            },
            },
    },
    };
    </script>
    <script src="misc/login.js" defer></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-body dark:bg-darkBody text-black dark:text-white flex-col">
    <div class="max-w-2xl w-full border border-gray-500 p-8 bg-modal dark:bg-darkModal shadow-lg rounded-md">
        <div class="flex flex-col gap-4">
            <h2 class="text-center text-3xl font-bold">Ielogoties sistēmā</h2>
            <?php
                if(isset($_SESSION['loginError'])){
                    echo '<div class="bg-red-500 text-white p-2 rounded-md text-center">'.$_SESSION['loginError'].'</div>';
                    unset($_SESSION['loginError']);
                }
            ?>
            <form action="database/login.php" method="POST" class="grid grid-cols-1 gap-4">
                <div class="flex flex-col">
                    <label class="text-xl">Lietotājvārds:</label>
                    <input type="text" name="username" required class="border border-gray-500 rounded-md p-1 text-black">
                </div>
                <div class="flex flex-col">
                    <label class="text-xl">Parole:</label>
                    <input type="password" name="password" required class="border border-gray-500 rounded-md p-1 text-black">
                </div>
                <button type="submit" name="login" class="border border-gray-500 p-2 rounded-md bg-body hover:bg-orange-200 dark:bg-darkBody dark:hover:bg-zinc-900">Nosūtīt</button>
            </form>
        </div>
    </div>
    <?php
    require 'components/footer.php';
?>
</body>
</html>