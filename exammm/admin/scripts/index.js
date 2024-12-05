$(document).ready(() => {
  const headings = [
    'ID',
    'Vārds',
    'Uzvārds',
    'Reg. datums',
    'Grāmata',
    'Statuss',
  ];

  $('#readersHead').append(
    headings
      .map((heading) => {
        if (heading === 'Reg. datums') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider md:table-cell hidden">${heading}</th>`;
        } else if (heading === 'Uzvārds') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider md:table-cell hidden">${heading}</th>`;
        } else {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider">${heading}</th>`;
        }
      })
      .join(''),
  );

  const fetchReaders = () => {
    $.ajax({
      url: 'database/readers/readers.php',
      type: 'GET',
      success: (res) => {
        const readers = JSON.parse(res);
        let template = '';

        $('#waiting').text(
          readers.filter((reader) => reader.status === 'Gaida').length,
        );

        $('#reading').text(
          readers.filter((reader) => reader.status === 'Apstiprināts').length,
        );

        $.get('database/books/books.php', (res) => {
          const books = JSON.parse(res);

          const booksInStorage = books.filter(
            (book) => book.inStorage === 'Jā',
          );

          $('#inStorage').text(booksInStorage.length);
        });

        readers.slice(0, 7).forEach((reader) => {
          template += `<tr readerId="${reader.id}" class="${
            reader.deadlineExceeded ? 'bg-red-300' : 'bg-nav dark:bg-darkNav'
          } border-b border-gray-500 ">
              <td class="sm:px-6 px-2 py-4 ">${reader.id}</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.name}</td>
              <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
                reader.lastName
              }</td>
              <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
                reader.date
              }</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.book}</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.status}</td>
          </tr>`;
        });
        $('#readersBody').html(template);
      },
      error: (err) => {
        console.log(err);
      },
    });
  };

  fetchReaders();
});
