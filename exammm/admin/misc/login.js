const isDarkMode = localStorage.getItem('darkMode') === 'true';
document.documentElement.classList.toggle('dark', isDarkMode);
