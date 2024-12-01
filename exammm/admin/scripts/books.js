$(document).ready(() => {
  const updateText = () => {
    if (window.innerWidth < 515) {
      $('#newBookButton').text('+');
    } else {
      $('#newBookButton').text('+ Pievienot grāmatu');
    }
  };

  updateText();

  $(window).resize(updateText);

  const headings = [
    'ID',
    'Nosaukums',
    'Autors',
    'Izdošanas gads',
    'Noliktavā',
    '',
  ];

  $('#booksHead').append(
    headings
      .map((heading) => {
        if (heading === 'Izdošanas gads') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider sm:block hidden">${heading}</th>`;
        } else {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider">${heading}</th>`;
        }
      })
      .join(''),
  );

  $('#booksBody').append(
    Array(10)
      .fill(0)
      .map(
        (_, i) =>
          `<tr class="bg-nav dark:bg-darkNav border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${i + 1}</td>
            <td class="sm:px-6 px-2 py-4 ">Dzeltenās acis</td>
            <td class="sm:px-6 px-2 py-4 ">Linards Sils</td>
            <td class="sm:px-6 px-2 py-4 sm:block hidden">2024-01-01</td>
            <td class="sm:px-6 px-2 py-4 ">Jā</td>
            <td class="sm:px-6 px-2 py-4 ">
                <button class="px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></button>
                <button class="px-2 py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>`,
      )
      .join(''),
  );
});
