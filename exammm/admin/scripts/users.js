$(document).ready(() => {
  let edit = false;

  const headings = [
    'ID',
    'Lietotājvārds',
    'Vārds',
    'Uzvārds',
    'E-pasts',
    'Tiesības',
    '',
  ];

  $('#usersHead').append(
    headings
      .map((heading) => {
        if (heading === 'E-pasts') {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider md:table-cell hidden">${heading}</th>`;
        } else {
          return `<th class="sm:px-6 px-2 py-3 text-left text-xs font-medium uppercase tracking-wider">${heading}</th>`;
        }
      })
      .join(''),
  );

  const fetchUsers = () => {
    $.ajax({
      url: 'database/users/users.php',
      type: 'GET',
      success: (res) => {
        const users = JSON.parse(res);
        let template = '';

        users.forEach((user) => {
          template += `<tr userId="${user.id}" class="bg-nav dark:bg-darkNav border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${user.id}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.username}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.name}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.lastName}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${user.email}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.role}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a id="userEdit" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a id="userDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
        });
        $('#usersBody').html(template);
      },
      error: (err) => {
        console.log(err);
      },
    });
  };

  fetchUsers();

  const updateText = () => {
    if (window.innerWidth < 515) {
      $('#newUserButton').text('+');
    } else {
      $('#newUserButton').text('+ Pievienot lietotāju');
    }
  };

  updateText();

  $(window).resize(updateText);

  const getTemplate = (edit) => {
    return `
    <div class="grid gap-4 grid-cols-2">
              <label for="username" class="text-xl">Lietotājvārds:</label>
              <input type="text" name="username" id="username" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="name" class="text-xl">Vārds:</label>
              <input type="text" name="name" id="name" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="lastName" class="text-xl">Uzvārds:</label>
              <input type="text" name="lastName" id="lastName" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="email" class="text-xl">E-pasts:</label>
              <input type="email" name="email" id="email" required class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
              <label for="role" class="text-xl">Tiesības:</label>
              <select  name="role" id="role" class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
                 <option  value="admin">Administrators</option>
                 <option value="moderator">Moderators</option>
              </select>
              <label for="password" class="text-xl">Parole:</label>
              <input type="password" placeholder="*****" name="password" id="password" ${
                edit ? '' : 'required'
              } class="shadow-md border border-gray-500 rounded-md p-1 dark:bg-zinc-900 bg-body">
          </div>
          <input type="hidden" name="id" id="id">
          <button type="submit" class="w-full mt-4 border border-gray-500 p-2 rounded-md hover:bg-nav bg-orange-200  dark:bg-zinc-700 dark:hover:bg-darkNav">Pievienot</button>
    `;
  };

  const refreshForm = () => {
    $('#userForm').html(getTemplate(edit));
  };

  $('#newUserButton').click(() => {
    $('#userModal').toggleClass('show-menu');
    $('#userForm').trigger('reset');
    $('#modalTitle').text('Pievienot lietotāju');
    edit = false;
    refreshForm();
  });

  $('#modalClose').click(() => {
    $('#userModal').toggleClass('show-menu');
    $('#userForm').trigger('reset');
    $('#errorAdd').addClass('hidden');
    $('#errorAdd').removeClass('!block');
    edit = false;
  });

  $('#userForm').submit((e) => {
    e.preventDefault();

    const formData = {
      username: $('#username').val(),
      name: $('#name').val(),
      lastName: $('#lastName').val(),
      email: $('#email').val(),
      role: $('#role').val(),
      password: $('#password').val(),
      id: $('#id').val() || null,
    };

    const url = edit
      ? 'database/users/edit-user.php'
      : 'database/users/add-user.php';

    $.ajax({
      url,
      type: 'POST',
      data: formData,
      success: (res) => {
        fetchUsers();
        $('#userModal').toggleClass('show-menu');
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

  $(document).on('click', '#userDelete', (e) => {
    if (confirm('Vai tiešām vēlaties dzēst lietotāju?')) {
      const element = $(e.currentTarget).closest('tr');
      const id = element.attr('userId');

      $.post('database/users/delete-user.php', { id }, (res) => {
        fetchUsers();
      });
    }
  });

  $(document).on('click', '#userEdit', (e) => {
    edit = true;

    $('#userModal').toggleClass('show-menu');
    $('#userForm').trigger('reset');
    $('#modalTitle').text('Rediģēt grāmatu');
    refreshForm();

    const element = $(e.currentTarget).closest('tr');
    const id = element.attr('userId');

    $.post('database/users/user.php', { id }, (res) => {
      const user = JSON.parse(res);
      console.log(user);
      $('#username').val(user.username);
      $('#name').val(user.name);
      $('#lastName').val(user.lastName);
      $('#email').val(user.email);
      $('#role').val(user.role);
      $('#id').val(user.id);
      edit = true;
    });
  });

  $('#search').submit((e) => {
    e.preventDefault();
    const search = $('#searchInput').val();

    if (search === '') {
      fetchUsers();
      return;
    }

    $.post('database/users/search-user.php', { search }, (res) => {
      const users = JSON.parse(res);
      let template = '';
      users.forEach((user) => {
        template += `<tr userId="${user.id}" class="bg-nav dark:bg-darkNav border-b border-gray-500 ">
            <td class="sm:px-6 px-2 py-4 ">${user.id}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.username}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.name}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.lastName}</td>
            <td class="sm:px-6 px-2 py-4 md:table-cell hidden">${user.email}</td>
            <td class="sm:px-6 px-2 py-4 ">${user.role}</td>
            <td class="sm:px-6 px-2 py-4 ">
                <a id="userEdit" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-pencil"></i></a>
                <a id="userDelete" class="hover:bg-nav dark:hover:bg-darkNav px-2 cursor-pointer py-1 border border-gray-500 bg-orange-200 dark:bg-zinc-700 rounded-md"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>`;
      });
      $('#usersBody').html(template);
    });
  });
});
