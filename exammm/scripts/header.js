document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.querySelector('.hamburger');
  const menu = document.getElementById('menu');
  const darkModeToggle = document.getElementById('darkModeToggle');
  const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
  const themeIcon = document.getElementById('themeIcon');
  const themeIconMobile = document.getElementById('themeIconMobile');

  const isDarkMode = localStorage.getItem('darkMode') === 'true';
  document.documentElement.classList.toggle('dark', isDarkMode);
  updateThemeIcons(isDarkMode);

  darkModeToggle.addEventListener('click', function () {
    toggleDarkMode();
    updateThemeIcons(document.documentElement.classList.contains('dark'));
  });

  hamburger.addEventListener('click', function () {
    menu.classList.toggle('show-menu');
  });

  window.onscroll = function () {
    menu.classList.remove('show-menu');
  };

  darkModeToggleMobile.addEventListener('click', function () {
    toggleDarkMode();
    updateThemeIcons(document.documentElement.classList.contains('dark'));
  });

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 640) {
      menu.classList.add('hidden');
      menu.classList.remove('show-menu');
    }
  });

  function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem(
      'darkMode',
      document.documentElement.classList.contains('dark'),
    );
  }

  function updateThemeIcons(isDarkMode) {
    if (isDarkMode) {
      themeIcon.classList.replace('fa-moon', 'fa-sun');
      themeIconMobile.classList.replace('fa-moon', 'fa-sun');
    } else {
      themeIcon.classList.replace('fa-sun', 'fa-moon');
      themeIconMobile.classList.replace('fa-sun', 'fa-moon');
    }
  }
});
