$(document).ready(() => {
  let edit = false;
  $('#newReaderButton').addClass('hidden');

  const headings = [
    'ID',
    'Vārds',
    'Uzvārds',
    'E-pasts',
    'Reģistrācijas datums',
    'Izvēlētā grāmata',
    'Statuss',
    '',
  ];

  $('#readersHead').append(
    headings
      .map((heading) => {
        if (heading === 'E-pasts') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider md:table-cell hidden">${heading}</th>`;
        } else if (heading === 'Reģistrācijas datums') {
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

        console.log(readers);

        readers.forEach((reader) => {
          template += `<tr readerId="${reader.id}" class="${
            reader.deadlineExceeded ? 'bg-red-300' : 'bg-nav dark:bg-darkNav'
          } border-b border-gray-500 ">
              <td class="sm:px-6 px-2 py-4 ">${reader.id}</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.name}</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.lastName}</td>
              <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
                reader.email
              }</td>
              <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
                reader.date
              }</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.book}</td>
              <td class="sm:px-6 px-2 py-4 ">${reader.status}</td>
              <td class="sm:px-6 px-2 py-4 ">
                  <a id="readerEdit" class="px-2 cursor-pointer py-1 border border-gray-500 hover:bg-nav dark:hover:bg-darkNav bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                  <a id="readerDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
              </td>
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

  const getTemplate = (edit) => {
    return `
        <div class="grid gap-4 grid-cols-2">
          <label for="name" class="text-xl">Vārds:</label>
          <input disabled type="text" name="name" id="name" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          <label for="lastName" class="text-xl">Uzvārds:</label>
          <input disabled type="text" name="lastName" id="lastName" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          <label for="email" class="text-xl">E-pasts:</label>
          <input disabled type="email" name="email" id="email" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          <label for="reg_date" class="text-xl">Reģistrācijas datums:</label>
          <input disabled type="text" name="reg_date" id="reg_date" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          <label for="phone" class="text-xl">Telefons:</label>
          <input disabled type="text" name="phone" id="phone" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          <label for="status" class="text-xl">Statuss:</label>
            <select name="status" id="status" class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <option  value="waiting">Gaida</option>
              <option value="taken">Apstiprināts</option>
              <option value="returned">Grāmatu atgriezis</option>
              <option value="denied">Noraidīts</option>
            </select>
        </div>
        <div class="mt-2 flex flex-col gap-2">
          <h2 class="text-xl font-bold">Informācijas par grāmatu:</h2>
          <div class="grid gap-4 grid-cols-2">
           <label for="book" class="text-xl">Izvēlētā grāmata:</label>
            <input disabled type="text" name="book" id="book" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">

            <label for="dateTaken" class="text-xl">Datums paņemta:</label>
            <input disabled type="text" name="dateTaken" id="dateTaken" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
            <label for="dateReturned" class="text-xl">Datums atdota:</label>
            <input disabled type="text" name="dateReturned" id="dateReturned" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          </div>
        </div>
        <input type="hidden" name="id" id="id">
        <button type="submit" class="w-full mt-4 border border-gray-500 p-2 rounded-md hover:bg-nav bg-orange-200  dark:bg-zinc-700 dark:hover:bg-darkNav">Pievienot</button>
        `;
  };

  const refreshForm = () => {
    $('#readerForm').html(getTemplate(edit));
  };

  $('#modalClose').click(() => {
    $('#readerModal').toggleClass('show-menu');
    $('#readerForm').trigger('reset');
    $('#errorAdd').addClass('hidden');
    $('#errorAdd').removeClass('!block');
    edit = false;
  });

  $('#readerForm').submit((e) => {
    e.preventDefault();

    const formData = {
      status: $('#status').val(),
      id: $('#id').val() || null,
    };

    const url = edit ? 'database/readers/edit-reader.php' : '';

    $.ajax({
      url,
      type: 'POST',
      data: formData,
      success: (res) => {
        fetchReaders();
        $('#readerModal').toggleClass('show-menu');
        $('#errorAdd').addClass('hidden');
        $('#errorAdd').removeClass('!block');
      },
      error: (err) => {
        $('#errorAdd').removeClass('hidden');
        $('#errorAdd').toggleClass('!block');
        $('#errorAdd').text(err.responseText);
      },
    });
  });

  $(document).on('click', '#readerDelete', (e) => {
    if (confirm('Vai tiešām vēlaties dzēst lietotāju?')) {
      const element = $(e.currentTarget).closest('tr');
      const id = element.attr('readerId');

      $.post('database/readers/delete-reader.php', { id }, (res) => {
        fetchReaders();
      });
    }
  });

  $(document).on('click', '#readerEdit', (e) => {
    edit = true;

    $('#readerModal').toggleClass('show-menu');
    $('#readerForm').trigger('reset');
    $('#modalTitle').text('Rediģēt Lasītāju');
    refreshForm();

    const element = $(e.currentTarget).closest('tr');
    const id = element.attr('readerId');

    $.post('database/readers/reader.php', { id }, (res) => {
      const reader = JSON.parse(res);
      console.log(reader);
      $('#name').val(reader.name);
      $('#lastName').val(reader.lastName);
      $('#email').val(reader.email);
      $('#reg_date').val(reader.date);
      $('#status').val(reader.status);
      $('#book').val(reader.title);
      $('#dateTaken').val(reader.dateTaken);
      $('#dateReturned').val(reader.dateReturned);
      $('#phone').val(reader.phone);
      $('#id').val(reader.id);
      edit = true;
    });
  });

  $('#search').submit((e) => {
    e.preventDefault();
    const search = $('#searchInput').val();

    if (search === '') {
      fetchReaders();
      return;
    }

    $.post('database/readers/search-reader.php', { search }, (res) => {
      const readers = JSON.parse(res);
      let template = '';

      readers.forEach((reader) => {
        template += `<tr readerId="${reader.id}" class="${
          reader.deadlineExceeded ? 'bg-red-300' : 'bg-nav dark:bg-darkNav'
        } border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${reader.id}</td>
            <td class="sm:px-6 px-2 py-4 ">${reader.name}</td>
            <td class="sm:px-6 px-2 py-4 ">${reader.lastName}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
              reader.email
            }</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${
              reader.date
            }</td>
            <td class="sm:px-6 px-2 py-4 ">${reader.book}</td>
            <td class="sm:px-6 px-2 py-4 ">${reader.status}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a id="readerEdit" class="px-2 cursor-pointer py-1 border border-gray-500 hover:bg-nav dark:hover:bg-darkNav bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a id="readerDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
      });
      $('#readersBody').html(template);
    });
  });
});
