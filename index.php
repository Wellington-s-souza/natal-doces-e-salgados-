<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Natal Doces e Salgados</title>
  <link rel="icon" type="image/x-icon" href="img/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header class="header">
    <div class="container header-content">
      <div class="logo">
      <img src="img/logo.png"  alt="Natal Doces e Salgados">
      </div>
  <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
  <span></span>
  <span></span>
  <span></span>
  </button>
      <nav class="nav" id="navMenu">
        <ul>
          <li><a href="#inicio">Início</a></li>
          <li><a href="#cardapio">Cardápio</a></li>
          <li><a href="#sobre">Sobre</a></li>
          <li><a href="#contato">Contato</a></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <section class="hero" id="inicio">
  <div class="container hero-content">
    <h2 data-aos="fade-up">Doces e salgados feitos com tradição</h2>
    <p data-aos="fade-up" data-aos-delay="150">Desde 2012 levando sabor e qualidade para a sua mesa</p>

    <div class="hero-botoes" data-aos="fade-up" data-aos-delay="300">
      <a href="#cardapio" class="btn">Ver Cardápio</a>
    </div>

    <div class="hero-selos" data-aos="fade-up" data-aos-delay="450">
      <div class="selo">
        <i class="fas fa-award"></i>
        <span>Desde 2012</span>
      </div>
      <div class="selo">
        <i class="fas fa-hand-sparkles"></i>
        <span>Feito Artesanalmente</span>
      </div>
      <div class="selo">
        <i class="fas fa-truck"></i>
        <span>Encomendas sob Consulta</span>
      </div>
    </div>
  </div>
</section>
<section class="cardapio" id="cardapio">
  <div class="container">
    <h2 class="section-title" data-aos="fade-down">Nosso Cardápio</h2>

    <h3 class="categoria-title" data-aos="fade-down" data-aos-once="true">Doces</h3>
    <div class="produtos-grid">
      <?php
      $sqlDoces = "SELECT * FROM produtos WHERE categoria = 'doce'";
      $resultadoDoces = mysqli_query($conexao, $sqlDoces);

      while ($produto = mysqli_fetch_assoc($resultadoDoces)){
       $mensagem = urlencode("Olá! Gostaria de saber mais sobre " . $produto['nome']);
       echo '
   <div class="produto-card" data-aos="fade-down" data-aos-delay="0" data-aos-once="true">
        <img src="img/' . htmlspecialchars($produto['imagem']) . '" alt="' . htmlspecialchars($produto['nome']) . '">
        <h3>' . htmlspecialchars($produto['nome']). '</h3>
        <p>' . htmlspecialchars($produto['descricao']) . '</p>
        <a href="https://wa.me/5500000000000?text=' . $mensagem . '" class="btn-pedido" target="_blank">
          <i class="fab fa-whatsapp"></i> Peça no WhatsApp
        </a>
    </div>';
    }
    ?>
   </div>
    <h3 class="categoria-title" data-aos="fade-up" data-aos-once="true">Salgados</h3>
    <div class="produtos-grid">
    <?php
    $sqlSalgados = "SELECT * FROM produtos WHERE categoria = 'salgado'";
    $resultadoSalgados = mysqli_query($conexao, $sqlSalgados);


while ($produto = mysqli_fetch_assoc($resultadoSalgados)){
  $mensagem = urlencode("Olá! Gostaria de saber mais sobre " . $produto['nome']);
  echo '
<div class="produto-card" data-aos="fade-up" data-aos-delay="0" data-aos-once="true">
        <img src="img/' . htmlspecialchars($produto['imagem']). '"alt="' . htmlspecialchars($produto['nome']). '">
        <h3>' . htmlspecialchars($produto['nome']). '</h3>
        <p>' . htmlspecialchars($produto['descricao']). '</p>
        <a href="https://wa.me/5500000000000?text=' . $mensagem . '" class="btn-pedido" target="_blank">
          <i class="fab fa-whatsapp"></i> Peça no WhatsApp
        </a>
    </div>';
}
 ?>
  </div>
  
</div>
</section>

<section class="sobre" id="sobre">
  <div class="container sobre-content">
    <div class="sobre-texto" data-aos="fade-right">
      <h2 class="section-title">Nossa História</h2>
      <p>Desde 2012, a Natal Doces e Salgados leva tradição, qualidade e sabor para a mesa de cada cliente. Cada receita é preparada com carinho, usando ingredientes selecionados e o cuidado de quem ama o que faz.</p>
      <p>Seja para um lanche do dia a dia ou para uma ocasião especial, nossos doces e salgados carregam o gostinho de casa que você procura.</p>
    </div>
    <div class="sobre-imagem" data-aos="fade-left">
      <img src="img/loja.jpg" alt="Loja Natal Doces e Salgados">
    </div>
  </div>
</section>

<section class="contato" id="contato">
  <div class="container contato-content">
    <h2 class="section-title" data-aos="fade-up">Fale Conosco</h2>
    <p data-aos="fade-up" data-aos-delay="100">Faça seu pedido ou tire suas dúvidas pelo WhatsApp</p>

    <a href="https://wa.me/5500000000000" class="btn btn-whatsapp" target="_blank" data-aos="zoom-in" data-aos-delay="200">
  <i class="fab fa-whatsapp"></i> Chamar no WhatsApp
   </a>

    <div class="contato-info" data-aos="fade-up" data-aos-delay="300">
      <div class="mapa-container" data-aos="fade-up">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3653.3395690208367!2d-46.63188042364043!3d-23.699564878705026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce44559ce9d959%3A0xcb5a5eb6cf8630cf!2sR.%20dos%20Pargos%2C%2027%20-%20Jardim%20Celia%20(Zona%20Sul)%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2004475-190%2C%20Brasil!5e0!3m2!1spt-BR!2sus!4v1789161971241!5m2!1spt-BR!2sus"
    width="100%"
    height="250"
    style="border:0;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>
      <p>📍 R. dos Pargos, 27 - Jardim Celia (Zona Sul), São Paulo - SP, 04475-190, Brasil</p>
      <p>🕒 Seg a Sáb, 8h às 18h</p>
    </div>

    <div class="redes-sociais" data-aos="fade-up" data-aos-delay="400">
  <a href="#"><i class="fab fa-instagram"></i></a>
  <a href="#"><i class="fab fa-facebook"></i></a>
</div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <p>&copy; 2026 Natal Doces e Salgados — Tradição, Qualidade e Sabor</p>
  </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>
<script>
  AOS.init({
   duration: 800,         // duração da animação em milissegundos
   once: false,          // anima só uma vez
   offset: -10,          // distância (em px) antes do elemento entrar na tela pra animação começar
   easing: 'ease-in-out', // "curva" de velocidade da animação (começa devagar, acelera, desacelera)
   delay: 0,             // atraso antes de começar (em ms) — pode ser sobrescrito por elemento
   mirror: false,        // se true, anima "ao contrário" quando o elemento sai de vista (só funciona com once: false)
  });
</script>
<script src="js/script.js"></script>
</body>
</html>