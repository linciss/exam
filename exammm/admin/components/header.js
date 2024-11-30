document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.querySelector('.hamburger');
  const menu = document.getElementById('menu');

  hamburger.addEventListener('click', function () {
    menu.classList.toggle('show-menu');
  });
});
