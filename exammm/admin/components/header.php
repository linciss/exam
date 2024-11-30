<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com" defer></script>
    <script>
      tailwind.config = {
        content: [
          './**/*.php',
          './**/*.html',
          './**/*.js',
          ],
        theme: {
          extend: {
            colors: {
              nav: '',
            }
          }
        }
      }
  </script>
    <title>Admin</title>
</head>
<body>
<header class="flex justify-between px-8 py-4 bg-[#fffdd0]">
        <a href="./" class="" id="logo-text">
            <i class="fa fa-server"></i> Bibliotech
        </a>
        <div class="flex flex-row gap-4 items-center">
            <a href="./" class="px-2 py-1 rounded-md border border-red-400">Sākums</a>
            <a href="./" class="px-2 py-1 rounded-md border border-red-400">Grāmatas</a>
            <a href="./" class="px-2 py-1 rounded-md border border-red-400">PRO īpašnieki</a>
            <a href="./" class="px-2 py-1 rounded-md border border-red-400">Lietotāji</a>
            <a href="logout.php" class="btn"><i class="fa-solid fa-power-off"></i></a>
        </div>
    </header>