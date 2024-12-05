<?php
require_once '../Classes/Selecao.php';
session_start();
session_destroy();

$busca = new Selecao();

$resultado = $busca->selecionarMangasPorNota();
foreach ($resultado as $listar) {
    $idManga[] = $listar['id_manga'];
    $mangaName[] = $listar['manga_name'];
    $yearPublication[] = $listar['year_publication'];
    $synopsis[] = $listar['synopsis'];
    $manga_critic_note[] = $listar['manga_critic_note'];
    $manga_link[] = $listar['manga_link'];
    $volumes[] = $listar['volumes'];
    $caminhoImgManga[] = $listar['name_img'];
}


?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros - VBooks</title>
    <link rel="stylesheet" href="../src/css/principal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    
    <!-- NAV-BAR DO VBOOKS -->
    <header class="container-nav">
        <div class="box-nav">
            <a href="/" aria-label="Voltar para a página inicial">
                <img src="../src/img/img-principais/logo_atualizada.png" alt="Logo do site">
            </a>
            <div class="search-container">
                <input type="text" placeholder="Buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <i class="fa-solid fa-x" aria-label="Fechar busca"></i>
            </div>
            <nav class="nav-links">
                <a href="/livros">Livros</a>
                <a href="/mangas">Mangás</a>
                <a href="/hqs">HQ's</a>
            </nav>
            <div class="user-flex">
                <i class="fa-solid fa-circle-user"></i>
                <p>@Renan</p>
            </div>
        </div>
    </header>
    <!-- NAV-BAR DO VBOOKS -->

    <!-- CARROSSEL PRINCIPAL -->
    <section class="carrossel-principal">
        <div class="carrossel-container">
            <div class="carrossel-slide">
                <img src="../src/img/img-carrosel/img1.png" alt="Slide 1">
            </div>
            <div class="carrossel-slide">
                <img src="../src/img/img-carrosel/img2.png" alt="Slide 2">
            </div>
            <div class="carrossel-slide">
                <img src="../src/img/img-carrosel/img3.png" alt="Slide 3">
            </div>
            <div class="carrossel-slide">
                <img src="../src/img/img-carrosel/img4.png" alt="Slide 4">
            </div>
            <!-- <button class="carrossel-button anterior" onclick="moverSlide(-1)">&#10094;</button>
            <button class="carrossel-button proximo" onclick="moverSlide(1)">&#10095;</button> -->
        </div>
    </section>

   <!-- FRASES SOBRE A EMPRESA -->
    <section class="info-empresa">
        <div class="info-item">
            <i class="fa-solid fa-book-open"></i> 
            <h3>Milhões de Títulos</h3>
            <p>Uma vasta coleção de livros de todo o mundo.</p>
        </div>
        <div class="info-item">
            <i class="fa-solid fa-shield-alt"></i> 
            <h3>Site Seguro</h3>
            <p>Navegue com confiança, sua segurança é nossa prioridade.</p>
        </div>
        <div class="info-item">
            <i class="fa-solid fa-magnifying-glass"></i>
            <h3>Facilidade de Navegação</h3>
            <p>Encontre o que procura de forma rápida e simples.</p>
        </div>
    </section>

 <!-- CARROSSEL DE LIVROS MAIS AVALIADOS -->
<section class="carrossel-livros">
    <h2>Mangás Mais Avaliados</h2>
    <div class="carrossel-container-livros">
        <button class="carrossel-button anterior-livro" onclick="moverSlideLivros(-1)">&#10094;</button>
        <div class="carrossel-wrapper-livros">
            <?php for ($i = 0; $i < 7; $i++) {  ?>
                <div class="carrossel-slide-livro">
                        <div class="card-livro">
                            <button class="add-lista">+</button>
                            <img src="../arquivos_enviados_mangas/<?= $caminhoImgManga[$i]; ?>">
                            <div class="info-livro">
                                <p class="nome"> <?= $mangaName[$i]; ?></p>
                                <p class="nota"><?= $manga_critic_note[$i]; ?></p>
                            </div>
                        </div>
                </div>
            <?php }?>
            
        </div>
        <button class="carrossel-button proximo-livro" onclick="moverSlideLivros(1)">&#10095;</button>
    </div>
</section>

    <!-- RODAPÉ -->
    <footer class="footer">
        <p>&copy; 2024 VBooks - Toda pirataria da Boa.</p>
    </footer>
    
    <script src="../src/js/carrosel.js"></script>
</body>
</html>