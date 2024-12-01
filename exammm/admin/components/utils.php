<div class="flex flex-row gap-2 justify-between items-center container mx-auto mt-5 md:px-0 px-8 text-black dark:text-white">
    <form class="flex flex-row gap-1">
        <input type="text" name="search" placeholder="Meklēt <?php echo $type ?>" class="w-full xs:w-full border border-gray-500  px-2 py-1 rounded-md bg-white dark:bg-zinc-900">
        <button type="submit" class="hover:bg-nav dark:hover:bg-darkNav px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md">Meklēt</button>
    </form>

    <button id="<?php echo $buttonType ?>" class="dark:hover:bg-darkNav hover:bg-nav px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md ">
        + Pievienot <?php echo $type ?>
    </button>
</div>