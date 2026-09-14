// MENU ABRIR
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('ativo');
  navMenu.classList.toggle('ativo');
});

// Fecha o menu automaticamente quando clica em algum link
const navLinks = navMenu.querySelectorAll('a');
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    menuToggle.classList.remove('ativo');
    navMenu.classList.remove('ativo');
  });
});

window.addEventListener('scroll', () => {
  const header = document.querySelector('.header');
  if (window.scrollY > 50) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});