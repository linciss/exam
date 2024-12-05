$(document).ready(() => {
  let currentPage = 1;
  const itemsPerPage = 8;

  const fetchBooks = (page = 1) => {
    $.ajax({
      url: `books/books.php?page=${page}`,
      type: 'GET',
      success: (res) => {
        const { books } = JSON.parse(res);

        const { totalItems } = JSON.parse(res);
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        let template = '';

        books.forEach((book) => {
          template += `
            <div class="group relative bookItem cursor-pointer" data-id=${
              book.id
            }>
            <img id="bookCover" src="${
              book.cover ? `data:image/jpeg;base64,${book.cover}` : ''
            }" alt="" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80">
            <div class="mt-4 flex justify-between">
              <div>
              <h3 class="text-sm ">
                  <a">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    <p id="bookTitle">${book.title}</p>
                  </a>
                </h3>
                <p class="mt-1 text-sm " id="author">${book.author}</p>
                <p class="mt-1 text-sm " id="genre">${book.genre}</p>
              </div>
              <p class="text-sm font-medium " id="release">${
                book.releaseDate
              }</p>
            </div>
          </div>
            `;
        });
        $('#bookSection').html(template);
        let paginationTemplate = '';
        for (let i = 1; i <= totalPages; i++) {
          paginationTemplate += `<button class="mt-2 pagination-button py-1 px-2 bg-orange-200 hover:bg-nav dark:bg-zinc-700 dark:hover:bg-darkNav border border-gray-500 rounded-md" data-page="${i}">${i}</button>`;
        }
        $('#paginationControls').html(paginationTemplate);
      },
      error: (err) => {
        console.log(err);
      },
    });
  };

  fetchBooks(currentPage);

  $(document).on('click', '.pagination-button', function () {
    currentPage = $(this).data('page');
    fetchBooks(currentPage);
  });

  $(document).on('click', '.bookItem', function () {
    const bookId = $(this).data('id');
    let formTemplate = ``;
    $.post('books/book.php', { bookId }, (res) => {
      const book = JSON.parse(res);

      formTemplate = `
      <h2 class="text-center text-xl font-semibold mb-2">${book.title}</h2>
        <div class="grid gap-4 grid-cols-2">
            <label for="name" class="text-xl">Vārds<span class='text-red-500'>*</span>:</label>
            <input type="text" name="name" id="name" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            <label for="lastName" class="text-xl">Uzvārds<span class='text-red-500'>*</span>:</label>
            <input type="text" name="lastName" id="lastName" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            <label for="email" class="text-xl">Epasts<span class='text-red-500'>*</span>:</label>
            <input type="email" name="email" id="email" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            <label for="phone" class="text-xl">Telefona nr.<span class='text-red-500'>*</span>:</label>
            <input type="text" name="phone" id="phone" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
        </div>
        <input type="hidden" name="id" id="id" value="${book.id}">
        <button type="submit" class="w-full mt-4 border border-gray-500 p-2 rounded-md hover:bg-nav bg-orange-200  dark:bg-zinc-700 dark:hover:bg-darkNav">Pieteikties</button>
        `;

      $('#readerForm').html(formTemplate);
    });

    $('#readerModal').toggleClass('show-menu');
    $('#readerForm').trigger('reset');
    $('#modalTitle').text('Pieteikties pie grāmatas');
    removeSuccess();
  });

  $('#modalClose').click(() => {
    $('#readerModal').toggleClass('show-menu');
    $('#readerForm').trigger('reset');
    $('#errorAdd').addClass('hidden');
    $('#errorAdd').removeClass('!block');
    removeSuccess();
  });

  $('#readerForm').submit((e) => {
    e.preventDefault();

    const formData = {
      name: $('#name').val(),
      lastName: $('#lastName').val(),
      email: $('#email').val(),
      phone: $('#phone').val(),
      bookId: $('#id').val(),
    };

    const url = 'books/apply.php';
    $.ajax({
      url,
      type: 'POST',
      data: formData,
      success: (res) => {
        $('#errorAdd').addClass('hidden');
        $('#errorAdd').removeClass('!block');
        showSuccess();
        setTimeout(() => {
          if ($('#readerModal').hasClass('show-menu')) {
            $('#readerModal').toggleClass('show-menu');
          }
          removeSuccess();
          $('#readerForm').trigger('reset');
        }, 2000);
      },
      error: (err) => {
        $('#errorAdd').removeClass('hidden');
        $('#errorAdd').toggleClass('!block');
        $('#errorAdd').text(err.responseText);
      },
    });
  });

  const removeSuccess = () => {
    $('#successAdd').removeClass('!block');
    $('#successAdd').addClass('hidden');
    $('#successMessage').removeClass('!block');
    $('#successMessage').addClass('hidden');
  };

  const showSuccess = () => {
    $('#successAdd').removeClass('hidden');
    $('#successAdd').toggleClass('!block');
    $('#successMessage').removeClass('hidden');
    $('#successMessage').toggleClass('!block');
  };
});
