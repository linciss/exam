$(document).ready(() => {
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
            <td class="sm:px-6 px-2 py-4 ">${book.name}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.author}</td>
            <td class="sm:px-6 px-2 py-4 ">${book.genre}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${book.releaseDate}</td>
            <td class="sm:px-6 px-2 py-4 sm:table-cell hidden">${book.inStorage}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a class="px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a class="px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
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

  $('#newBookButton').click(() => {
    $('#bookModal').toggleClass('show-menu');
    $('#bookForm').trigger('reset');
    $('#modalTitle').text('Pievienot grāmatu');

    const formTemplate = `

    `;
  });

  $('#modalClose').click(() => {
    $('#bookModal').toggleClass('show-menu');
  });
});
