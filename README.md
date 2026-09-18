# 🍞 Natal Doces e Salgados

Site funcional para confeitaria, com cardápio dinâmico integrado a banco de dados.

## 🔗 Demonstração

https://nataldocesesalgados.rf.gd/

## 🛠️ Tecnologias utilizadas

- HTML5 e CSS3
- JavaScript (vanilla)
- PHP
- MySQL
- [AOS](https://michalsnik.github.io/aos/) (animações ao rolar a página)
- Font Awesome (ícones)
- Google Fonts (Playfair Display + Poppins)

## ✨ Funcionalidades

- Cardápio dinâmico, gerado a partir de um banco de dados MySQL
- Pedidos via WhatsApp com mensagem pré-preenchida por produto
- Header fixo com menu responsivo (hambúrguer no mobile)
- Animações suaves ao rolar a página
- Mapa integrado com a localização da loja
- Design totalmente responsivo

## 🗄️ Estrutura do banco de dados

Tabela `produtos`:

| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Identificador único (auto increment) |
| nome | VARCHAR(100) | Nome do produto |
| descricao | VARCHAR(255) | Descrição curta |
| categoria | VARCHAR(50) | 'doce' ou 'salgado' |
| imagem | VARCHAR(100) | Nome do arquivo de imagem |
| destaque | TINYINT(1) | Reservado para produtos em destaque |


## 👤 Autor

Wellington — [GitHub](https://github.com/Wellington-s-souza)