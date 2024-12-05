<?php
require_once '../Classes/Selecao.php';
$busca = new Selecao();
$resultado = $busca->selecionarGeneros();
foreach ($resultado as $listar) {
  $idGenero[] = $listar['id_gender'];
  $descGenero[] = $listar['desc_gender'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - ADD</title>
    <link rel="stylesheet" href="../src/css/adm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <section class="container-principal">
        
        <!-- NAV-BAR DO VBOOKS -->
        <header class="container-nav">
            <div class="box-nav">
                <a href="/" aria-label="Voltar para a página inicial">
                    <img src="../src/img/img-principais/logo_atualizada.png" alt="Logo do site">
                </a>
                <div>
                    <input type="text" placeholder="Buscar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <i class="fa-solid fa-x"></i>
                </div>
                <a href="/perfil" aria-label="Acessar perfil do usuário">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
            </div>
        </header>

        <section class="container-adm">
            <div class="box-adm">
                <p class="titulo-add">ADICIONAR ITENS</p>
                <div class="buttons-container">
                    <button id="btnLivro">LIVROS</button>
                    <button id="btnManga">MANGÁ</button>
                    <button id="btnHq">HQ'S</button>
                </div>
            </div>
        </section>
    </section>

    <!-- Modal Livro -->
    <div id="modalLivro" class="modal">
        <div class="modal-content">
            <span class="close" data-modal="modalLivro">&times;</span>
            <h2>Adicionar Livro</h2>
            <form id="formLivro" method="post" action="../controllers/insertBooks.php" enctype="multipart/form-data">
                <label for="imagemLivro">Enviar Imagem:</label>
                <input type="file" id="imagemLivro" name="imagemLivro" accept="image/*" required>

                <label for="tituloLivro">Título:</label>
                <input type="text" id="tituloLivro" name="tituloLivro" required>

                <label for="sinopseLivro">Sinopse:</label>
                <textarea id="sinopseLivro" name="sinopseLivro" required></textarea>

                <label for="generoLivro">Gêneros:</label>
                <select id="generolivro" name="generoLivro[]" class="generos" multiple required>
                    <!-- As opções serão inseridas dinamicamente via PHP -->
                    <?php for ($i = 0; $i < count($idGenero); $i++) { ?>
                <option value="<?= $idGenero[$i]; ?>"><?= $descGenero[$i]; ?></option>
              <?php } ?>
                </select>

                <label for="anoLancamentoLivro">Ano de Lançamento:</label>
                <input type="number" id="anoLancamentoLivro" name="anoLancamentoLivro" step="1" required>

                <label for="autoresLivro">Autores/Autor:</label>
                <input type="text" id="autoresLivro" name="autoresLivro" required>

                <label for="numPaginasLivro">Número de Páginas:</label>
                <input type="number" id="numPaginasLivro" name="numPaginasLivro" step="1" min="1" required>

                <label for="classificacaoLivro">Classificação indicativa:</label>
                <input type="number" id="classificacaoLivro" name="classificacaoLivro" step="1" min="1" required>

                <label for="linkCompraLivro">Link de Compra:</label>
                <input type="url" id="linkCompraLivro" name="linkCompraLivro" required>

                <label for="avaliacaoLivro">Avaliação dos Críticos (0 a 10):</label>
                <input type="number" id="avaliacaoLivro" name="avaliacaoLivro" step="0.1" min="0" max="10" required>

                <div class="modal-buttons">
                    <button type="submit" class="adicionar">Adicionar</button>
                    <button type="button" class="cancelar" data-modal="modalLivro">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Mangá -->
    <div id="modalManga" class="modal">
        <div class="modal-content">
            <span class="close" data-modal="modalManga">&times;</span>
            <h2>Adicionar Mangá</h2>
            <form id="formManga" method="post" action="../controllers/insertMangas.php" enctype="multipart/form-data">

                <label for="nameImgmanga">Enviar Imagem:</label>
                <input type="file" id="nameImgmanga" name="nameImgmanga" required>

                <label for="tituloManga">Título:</label>
                <input type="text" id="tituloManga" name="tituloManga" required>

                <label for="sinopseManga">Sinopse:</label>
                <textarea id="sinopseManga" name="sinopseManga" required></textarea>

                <label for="generoManga">Gêneros:</label>
                <select id="generomanga" name="generomanga[]" class="generos" multiple required>
                    <!-- As opções serão inseridas dinamicamente via PHP -->
                    <?php for ($i = 0; $i < count($idGenero); $i++) { ?>
                <option value="<?= $idGenero[$i]; ?>"><?= $descGenero[$i]; ?></option>
              <?php } ?>
                </select>

                <label for="yearPublication">Ano de Lançamento:</label>
                <input type="number" id="yearPublication" name="yearPublication" step="1" required>

                <label for="autoresManga">Autores/Autor:</label>
                <input type="text" id="autoresManga" name="autoresManga" required>

                <label for="volumes">Número de Volumes:</label>
                <input type="number" id="volumes" name="volumes" step="1" min="1" required>

                <label for="classificacaoManga">Classificação indicativa:</label>
                <input type="number" id="classificacaoManga" name="classificacaoManga" step="1" min="1" required>

                <label for="linkCompraManga">Link de Compra:</label>
                <input type="url" id="linkCompraManga" name="linkCompraManga" required>

                <label for="avaliacaoManga">Avaliação dos Críticos (0 a 10):</label>
                <input type="number" id="avaliacaoManga" name="avaliacaoManga" step="0.1" min="0" max="10" required>

                <div class="modal-buttons">
                    <button type="submit" class="adicionar">Adicionar</button>
                    <button type="button" class="cancelar" data-modal="modalManga">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal HQ -->
    <div id="modalHq" class="modal">
        <div class="modal-content">
            <span class="close" data-modal="modalHq">&times;</span>
            <h2>Adicionar HQ</h2>
            <form id="formHq" method="post" action="../controllers/inserthq.php" enctype="multipart/form-data">
                <label for="imagemHq">Enviar Imagem:</label>
                <input type="file" id="imagemHq" name="imagemHq" accept="image/*" required>

                <label for="tituloHq">Título:</label>
                <input type="text" id="tituloHq" name="tituloHq" required>

                <label for="sinopseHq">Sinopse:</label>
                <textarea id="sinopseHq" name="sinopseHq" required></textarea>

                <label for="generoHq">Gêneros:</label>
                <select id="generohq" name="generohq[]" class="generos" multiple required>
                    <!-- As opções serão inseridas dinamicamente via PHP -->
                    <?php for ($i = 0; $i < count($idGenero); $i++) { ?>
                <option value="<?= $idGenero[$i]; ?>"><?= $descGenero[$i]; ?></option>
              <?php } ?>
                </select>

                <label for="AnoLancamentoHq">Data de Lançamento:</label>
                <input type="number" id="AnoLancamentoHq" name="AnoLancamentoHq" step="1" required>

                <label for="autoresHq">Autores/Autor:</label>
                <input type="text" id="autoresHq" name="autoresHq" required>

                <label for="numPaginasHq">Número de Páginas:</label>
                <input type="number" id="numPaginasHq" name="numPaginasHq" step="1" min="1" required>

                <label for="classificacaoHq">Classificação indicativa:</label>
                <input type="number" id="classificacaoHq" name="classificacaoHq" step="1" min="1" required>

                <label for="linkCompraHq">Link de Compra:</label>
                <input type="url" id="linkCompraHq" name="linkCompraHq" required>

                <label for="avaliacaoHq">Avaliação dos Críticos (0 a 10):</label>
                <input type="number" id="avaliacaoHq" name="avaliacaoHq" step="0.1" min="0" max="10" required>

                <div class="modal-buttons">
                    <button type="submit" class="adicionar">Adicionar</button>
                    <button type="button" class="cancelar" data-modal="modalHq">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.generos').select2({
                placeholder: "Selecione as categorias", // Texto que aparece quando nada é selecionado
                allowClear: true  // Permite que o usuário desmarque todas as opções
            });
        });
        </script>
        
    <!-- apenas pra fazer o modal/botão add e excluir ai -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modals = {
                modalLivro: document.getElementById("modalLivro"),
                modalManga: document.getElementById("modalManga"),
                modalHq: document.getElementById("modalHq")
            };

            const forms = {
                modalLivro: document.getElementById("formLivro"),
                modalManga: document.getElementById("formManga"),
                modalHq: document.getElementById("formHq")
            };

            document.getElementById("btnLivro").addEventListener("click", () => openModal("modalLivro"));
            document.getElementById("btnManga").addEventListener("click", () => openModal("modalManga"));
            document.getElementById("btnHq").addEventListener("click", () => openModal("modalHq"));

            document.querySelectorAll(".close, .cancelar").forEach((element) => {
                element.addEventListener("click", () => {
                    const modalId = element.getAttribute("data-modal");
                    closeModal(modalId);
                    resetForm(modalId);
                });
            });

            function openModal(modalId) {
                modals[modalId].style.display = "flex";
            }
            function closeModal(modalId) {
                modals[modalId].style.display = "none";
            }
            function resetForm(modalId) {
                if (forms[modalId]) {
                    forms[modalId].reset();
                }
            }
        });
    </script>
    
</body>
</html>
