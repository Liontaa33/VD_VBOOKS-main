<?php
require_once '../Classes/Insercao.php';

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário, ajuste conforme necessário

$bookName = $_POST["tituloLivro"];
$synopsis = $_POST["sinopseLivro"];
$pagesNumber = $_POST["numPaginasLivro"];
$author = $_POST["autoresLivro"];
$bookLink = $_POST["linkCompraLivro"];
$critictNote = $_POST["avaliacaoLivro"];
$classification = $_POST["classificacaoLivro"];
$yearPublication = $_POST["anoLancamentoLivro"];
$bookGenders = $_POST["generoLivro"] ?? []; // Recebe os gêneros selecionados
$nameImgBook = $_FILES["imagemLivro"];
$error = [];


// Data que o usuário inseriu o cadastro
$dateCadastre = date("Y-m-d H:i:s");

if (!empty($nameImgBook["name"])) {
  $tamanho = 5000000; // Limite de tamanho em bytes

  if ($nameImgBook["size"] > $tamanho) {
    $error[] = "O arquivo deve ter no máximo " . $tamanho . " bytes";
  }

  if (count($error) == 0) {
    // Verificar se a extensão do arquivo é uma imagem
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    preg_match("/\.(jpg|jpeg|png|gif)$/i", $nameImgBook["name"], $ext);

    if (isset($ext[1]) && in_array($ext[1], $extensoesPermitidas)) {
      $nameImgBookNew = md5(uniqid(time())) . "." . $ext[1];
      $caminho_img = "../arquivos_enviados_books/" . $nameImgBookNew;

      if (move_uploaded_file($nameImgBook["tmp_name"], $caminho_img)) {
        // Inserção no banco de dados
        $insere = new Insercao();

        $resultado = $insere->insertBooks(
          $bookName,
          $synopsis,
          $pagesNumber,
          $author,
          $bookLink,
          $critictNote,
          $classification,
          $yearPublication,
          $dateCadastre,
          $nameImgBookNew,
          $bookGenders
        );

        if ($resultado === "Ok") {
          header("Location: ../Tela_adm/adm.php");
          exit;
        } else {
          echo "Erro ao inserir dados no banco de dados: " . $resultado;
        }
      } else {
        echo "Erro ao mover o arquivo para o diretório.";
      }
    } else {
      echo "O arquivo deve ser uma imagem com as extensões .jpg, .jpeg, .png ou .gif.";
      echo "<a href='adm.php'>VOLTAR</a>";
      exit;
    }
  } else {
    // Exibe todos os erros, se houver
    foreach ($error as $e) {
      echo $e . "<br>";
    }
  }
} else {
  echo "Nenhum arquivo enviado.";
  echo "<a href='cadEntrada.php'>VOLTAR</a>";
}
?>
