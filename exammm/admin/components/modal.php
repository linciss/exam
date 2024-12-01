
<div class=" fixed top-0 bottom-0 right-0 left-0 hidden justify-center items-center mx-auto z-10 bg-[rgba(0,0,0,0.7)]" id="<?php echo $modalType ?>">
    <div class="rounded-md border border-gray-500 md:w-1/3 w-11/12 bg-body dark:bg-darkBody py-4 px-8 relative">
        <div class="cursor-pointer absolute top-2 right-2 py-1 px-2 bg-orange-200 dark:bg-zinc-700 border border-gray-500 rounded-md" id="modalClose">
            <i class="fa fa-times"></i>
        </div>
        <h1 id="modalTitle" class="text-4xl text-center">Pietiekums</h1>
        <form id="book-form" class="py-4 grid-cols-1 gap-8">
            <div class="grid gap-4 grid-cols-2">
                <label for="title" class="text-xl">Nosaukums:</label>
                <input type="text" name="title" id="title" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
                <label for="author" class="text-xl">Autors:</label>
                <input type="text" name="author" id="author" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
                <label for="genre" class="text-xl">Žanrs:</label>
                <input type="text" name="genre" id="genre" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
                <label for="release" class="text-xl">Izlaiduma datums:</label>
                <input type="date" name="release" id="release" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            </div>
            <div class="flex flex-col gap-2">
                <label for="cover" class="text-xl text-left">Vāka bilde:</label>
                <input type="file" name="cover" id="cover" required class="border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            </div>
           <button type="submit" class="w-full mt-4 border border-gray-500 p-2 rounded-md hover:bg-nav bg-orange-200 dark:bg-darkBody dark:hover:bg-zinc-900">Pievienot</button>
        </form>
    </div>
</div>