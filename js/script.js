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

// Guarda qual slide está sendo exibido no momento.
// Começa em 0 porque a primeira ação da função showSlides() é somar +1 nele
// (então, na prática, o primeiro slide mostrado será o de índice 1)
let slideIndex = 0;

// Guarda a "referência" do temporizador (setTimeout) que está agendado no momento.
// Precisamos disso para poder CANCELAR a troca automática quando o usuário
// clicar manualmente numa bolinha (senão as duas trocas "brigam" entre si)
let slideTimer;

// Chama a função uma vez, assim que a página carrega, para iniciar o carrossel
showSlides();

function showSlides() {
  let i; // variável de controle, usada nos dois "for" abaixo

  // Pega TODOS os elementos que têm a classe "mySlides" (as imagens do carrossel)
  // Retorna uma lista (parecido com um array)
  let slides = document.getElementsByClassName("mySlides");

  // Pega TODAS as bolinhas de navegação (elementos com classe "dot")
  let dots = document.getElementsByClassName("dot");

  // PASSO 1: Esconde TODOS os slides antes de mostrar o certo.
  // Isso evita que duas imagens apareçam sobrepostas ao mesmo tempo
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }

  // PASSO 2: Avança o índice para o próximo slide
  slideIndex++;

  // PASSO 3: Se passou do último slide (ex: slideIndex = 4, mas só existem 3 imagens),
  // volta para o primeiro (índice 1). Isso cria o efeito de "loop infinito"
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }    

  // PASSO 4: Remove a classe "active" de TODAS as bolinhas.
  // O .replace(" active", "") procura o texto " active" dentro do nome da classe
  // e remove ele, deixando a bolinha "normal" de novo (sem destaque visual)
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  // PASSO 5: Mostra APENAS o slide atual.
  // "slideIndex - 1" porque listas em JavaScript começam do índice 0,
  // mas nosso contador (slideIndex) começa do 1 — precisamos "traduzir" entre os dois
  slides[slideIndex - 1].style.display = "block";  

  // PASSO 6: Adiciona a classe "active" só na bolinha correspondente ao slide atual,
  // fazendo ela ficar destacada visualmente (via CSS: .dot.active { ... })
  dots[slideIndex - 1].className += " active";

  // PASSO 7: Agenda a PRÓPRIA função showSlides() para rodar de novo em 4000ms (4 segundos).
  // Como ela "se auto-chama" no final, isso cria um ciclo que se repete para sempre —
  // cada execução mostra o próximo slide e já agenda a chamada seguinte.
  // Guardamos essa "promessa de execução futura" na variável slideTimer,
  // para podermos cancelá-la depois, se necessário (veja currentSlide() abaixo)
  slideTimer = setTimeout(showSlides, 4000);
}

// Essa função é chamada pelo HTML quando o usuário clica numa bolinha específica
// (ex: onclick="currentSlide(2)" mostra o segundo slide)
function currentSlide(n) {
  // Cancela a troca automática que já estava agendada pelo setTimeout anterior.
  // Sem isso, poderíamos ter DUAS trocas de slide acontecendo quase ao mesmo tempo
  // (uma pelo clique manual, outra pelo temporizador antigo que ainda ia disparar)
  clearTimeout(slideTimer);

  // Prepara o índice para o slide desejado.
  // Fazemos "n - 1" porque, logo em seguida, showSlides() vai somar +1 automaticamente
  // (é o mesmo PASSO 2 explicado acima) — então precisamos "adiantar" um valor a menos
  slideIndex = n - 1;

  // Chama showSlides(), que agora vai mostrar exatamente o slide desejado
  // (e já agenda um novo ciclo automático de 4 segundos a partir daqui)
  showSlides();
}