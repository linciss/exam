<?php
session_start();
     if(!isset($_SESSION['lincisExam'])){
        header("Location: login.php");
        exit;
    }

    $pageTitle = 'Sākums';
    $scriptName = 'index.js';

    require 'components/header.php';
?>

<div class="mt-5 overflow-hidden container mx-auto rounded-md bg-white dark:bg-black px-4 py-8 text-black dark:text-white">
    <div class="grid lg:grid-flow-row lg:grid-cols-5 sm:grid-cols-3 grid-cols-1 gap-5">
        <div class="bg-nav dark:bg-darkNav p-2 flex flex-col gap-2 justify-center items-center col-span-full lg:col-span-2 rounded-md">
            <h2 class="text-3xl font-bold">Sveiki, <?php echo $_SESSION['lincisExam'] ?></h2>
            <p class="text-lg">Jūs esat ielogojies kā <?php echo $_SESSION['role'] === "admin" ? "Administrators" : "Moderators" ?></p>
        </div>

        <div class="bg-nav dark:bg-darkNav p-2 flex flex-row justify-center items-center gap-4 rounded-md">
            <div class="flex items-center justify-center w-10 h-10 bg-orange-200 dark:bg-zinc-700 rounded-full">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            <div>
                <p class="text-md font-semibold" id="waiting">3</p> 
                <h3 class="text-lg font-semibold" >Lasītāji gaida</h3>
            </div>
        </div>
        <div class="bg-nav dark:bg-darkNav p-2 flex flex-row justify-center items-center gap-4 rounded-md">
            <div class="flex items-center justify-center w-10 h-10 bg-orange-200 dark:bg-zinc-700 rounded-full">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <div>
                    <p class="text-md font-semibold" id="reading">3</p> 
                    <h3 class="text-lg font-semibold">Lasītāji apstiprināti</h3>
                </div>
            </div>
        <div class="bg-nav dark:bg-darkNav p-2 flex flex-row justify-center items-center gap-4 rounded-md">
            <div class="flex items-center justify-center w-10 h-10 bg-orange-200 dark:bg-zinc-700 rounded-full">
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
            <div>
                <p class="text-md font-semibold" id="inStorage">3</p> 
                <h3 class="text-lg font-semibold">Grāmatas noliktavā</h3>
            </div>
        </div>
    </div>
    <div class="grid  grid-cols-1 xl:grid-cols-2 mt-5 gap-5">
        <div class="text-center">
            <h2 class="text-2xl font-bold mt-5 mb-2 bg-nav dark:bg-darkNav rounded-md">Jaunākie lasītāji</h2>
            <?php
                $tableHead = 'readersHead';
                $tableBody = 'readersBody';
                require 'components/table.php'; 
             ?>
        </div>
        <div class="text-center ">
            <h2 class="text-2xl font-bold mt-5 mb-2 bg-nav dark:bg-darkNav rounded-md">Pēdējie notikumi</h2>
            <div>
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
</div>

<?php
    require 'components/footer.php';
?>
</body>
</html>