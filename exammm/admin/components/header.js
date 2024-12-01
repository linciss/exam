document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.querySelector('.hamburger');
  const menu = document.getElementById('menu');
  const darkModeToggle = document.getElementById('darkModeToggle');
  document.documentElement.classList.toggle(
    'dark',
    localStorage.getItem('darkMode') === 'true',
  );

  darkModeToggle.addEventListener('click', function () {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem(
      'darkMode',
      document.documentElement.classList.contains('dark'),
    );
  });

  hamburger.addEventListener('click', function () {
    menu.classList.toggle('show-menu');
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 640) {
      menu.classList.add('hidden');
      menu.classList.remove('show-menu');
    }
  });
});
