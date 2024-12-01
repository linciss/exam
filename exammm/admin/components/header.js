document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.querySelector('.hamburger');
  const menu = document.getElementById('menu');

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
