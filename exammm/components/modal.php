
<div class=" fixed top-0 bottom-0 right-0 left-0 hidden justify-center items-center mx-auto z-10 bg-[rgba(0,0,0,0.7)]" id="<?php echo $modalType ?>">
    <div class="rounded-md border border-gray-500 md:w-1/3 w-11/12 bg-body dark:bg-darkBody py-4 px-8 relative">
        <div class="cursor-pointer hover:bg-nav dark:hover:bg-darkNav absolute top-2 right-2 py-1 px-2 bg-orange-200 dark:bg-zinc-700 border border-gray-500 rounded-md" id="modalClose">
            <i class="fa fa-times"></i>
        </div>
        <h1 id="modalTitle" class="text-4xl text-center">Pietiekums</h1>
        <div id="errorAdd" class="bg-red-500 text-white p-2 rounded-md text-center hidden"></div>
        <div id="successAdd" class="bg-green-500 text-white p-2 rounded-md text-center hidden">Pieteikums veiksmīgs!</div>
        <div id="successMessage" class=" p-4 mt-2 text-center bg-nav dark:bg-darkNav text-black dark:text-white hidden">Dodieties uz mūsu bibliotēku Ventspils ielā 51. Jums ir 7 dienu laiks, lai grāmatu savāktu!</div>
        <form class="py-4 grid-cols-1 gap-8" id="<?php echo $formType ?>">
        </form>
    </div>
</div>