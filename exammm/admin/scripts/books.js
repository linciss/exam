$(document).ready(() => {
  let edit = false;
  const headings = [
    'ID',
    'Nosaukums',
    'Autors',
    'Žanrs',
    'Izdošanas gads',
    'Noliktavā',
    '',
  ];
  $('#booksHead').append(
    headings
      .map((heading) => {
        if (heading === 'Izdošanas gads') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider md:table-cell hidden">${heading}</th>`;
        } else if (heading === 'Noliktavā') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider sm:table-cell hidden">${heading}</th>`;
        } else {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider">${heading}</th>`;
        }
      })
      .join(''),
  );
  const fetchBooks = () => {
    $.ajax({
      url: 'database/books/books.php',
      type: 'GET',
      success: (res) => {
        const books = JSON.parse(res);
        let template = '';

        books.forEach((book) => {
          template += `<tr bookId="${book.id}" class="bg-nav dark:bg-darkNav border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${book.id}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.title}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.author}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.genre}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${book.releaseDate}</td>
            <td class="sm:px-6 px-2 py-4 sm:table-cell hidden">${book.inStorage}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a id="bookEdit" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a id="bookDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
        });
        $('#booksBody').html(template);
      },
      error: (err) => {
        console.log(err);
      },
    });
  };

  fetchBooks();

  const updateText = () => {
    if (window.innerWidth < 515) {
      $('#newBookButton').text('+');
    } else {
      $('#newBookButton').text('+ Pievienot grāmatu');
    }
  };

  updateText();

  $(window).resize(updateText);

  const getTemplate = (edit) => {
    return `
    <div class="grid gap-4 grid-cols-2">
              <label for="title" class="text-xl">Nosaukums:</label>
              <input type="text" name="title" id="title" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="author" class="text-xl">Autors:</label>
              <input type="text" name="author" id="author" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="genre" class="text-xl">Žanrs:</label>
              <input type="text" name="genre" id="genre" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="release" class="text-xl">Izlaiduma datums:</label>
              <input type="date" required name="release" id="release" class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="description" class="text-xl">Apraksts:</label>
              <textarea required name="description" id="description" class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body"></textarea>
              ${
                !edit
                  ? ''
                  : '<label for="inStorage" class="text-xl">Noliktavā:</label>'
              }
              ${
                !edit
                  ? ''
                  : '<select  name="inStorage" id="inStorage" class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body"><option value="yes">Jā</option><option value="no">Nē</option></select>'
              }
          </div>
          <div class="flex flex-col gap-2">
              <label for="cover" class="text-xl text-left">Vāka bilde:</label>
              <input type="file" name="cover" id="cover" class="border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          </div>
          <input type="hidden" name="id" id="id">
          <button type="submit" class="w-full mt-4 border border-gray-500 p-2 rounded-md hover:bg-nav bg-orange-200  dark:bg-zinc-700 dark:hover:bg-darkNav">Pievienot</button>
    `;
  };

  const refreshForm = () => {
    $('#bookForm').html(getTemplate(edit));
  };

  $('#newBookButton').click(() => {
    $('#bookModal').toggleClass('show-menu');
    $('#bookForm').trigger('reset');
    $('#modalTitle').text('Pievienot grāmatu');
    edit = false;
    refreshForm();
  });

  $('#modalClose').click(() => {
    $('#bookModal').toggleClass('show-menu');
    $('#bookForm').trigger('reset');
    $('#errorAdd').addClass('hidden');
    $('#errorAdd').removeClass('!block');
    edit = false;
  });

  $('#bookForm').submit((e) => {
    e.preventDefault();
    const formData = {
      title: $('#title').val(),
      author: $('#author').val(),
      genre: $('#genre').val(),
      release: $('#release').val(),
      cover: $('#cover').prop('files')[0] || null,
      description: $('#description').val(),
      inStorage: $('#inStorage').val() || null,
      id: $('#id').val() || null,
    };

    const url = edit
      ? 'database/books/edit-book.php'
      : 'database/books/add-book.php';

    $.ajax({
      url,
      type: 'POST',
      data: formData,
      success: (res) => {
        fetchBooks();
        $('#bookModal').toggleClass('show-menu');
        $('#errorAdd').addClass('hidden');
        $('#errorAdd').removeClass('!block');
      },
      error: (err) => {
        $('#errorAdd').removeClass('hidden');
        $('#errorAdd').toggleClass('!block');
        $('#errorAdd').text(err.responseText);
        console.log(err);
      },
    });
  });

  $(document).on('click', '#bookDelete', (e) => {
    if (confirm('Vai tiešām vēlaties dzēst grāmatu?')) {
      const element = $(e.currentTarget).closest('tr');
      const id = element.attr('bookId');

      $.post('database/books/delete-book.php', { id }, (res) => {
        fetchBooks();
      });
    }
  });

  $(document).on('click', '#bookEdit', (e) => {
    edit = true;

    $('#bookModal').toggleClass('show-menu');
    $('#bookForm').trigger('reset');
    $('#modalTitle').text('Rediģēt grāmatu');
    refreshForm();

    const element = $(e.currentTarget).closest('tr');
    const id = element.attr('bookId');

    $.post('database/books/book.php', { id }, (res) => {
      const book = JSON.parse(res);
      console.log(book);
      $('#title').val(book.title);
      $('#author').val(book.author);
      $('#genre').val(book.genre);
      $('#release').val(book.releaseDate);
      $('#description').val(book.description);
      $('#inStorage').val(book.inStorage);
      $('#id').val(book.id);
      edit = true;
    });
  });

  $('#search').submit((e) => {
    e.preventDefault();
    const search = $('#searchInput').val();

    if (search === '') {
      fetchBooks();
      return;
    }

    $.post('database/books/search-book.php', { search }, (res) => {
      const books = JSON.parse(res);
      let template = '';

      books.forEach((book) => {
        template += `<tr bookId="${book.id}" class="bg-nav dark:bg-darkNav border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${book.id}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.title}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.author}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.genre}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${book.releaseDate}</td>
            <td class="sm:px-6 px-2 py-4 sm:table-cell hidden">${book.inStorage}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a id="bookEdit" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a id="bookDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
      });
      $('#booksBody').html(template);
    });
  });
});
