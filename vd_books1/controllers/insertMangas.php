<?php
require_once '../Classes/Insercao.php';

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário, ajuste conforme necessário

$mangaName = $_POST["tituloManga"];
$synopsis = $_POST["sinopseManga"];
$volumes = $_POST["volumes"];
$author = $_POST["autoresManga"];
$mangaLink = $_POST["linkCompraManga"];
$critictNote = $_POST["avaliacaoManga"];
$classification = $_POST["classificacaoManga"];
$yearPublication = $_POST["yearPublication"];
$mangaGenders = $_POST["generomanga"] ?? []; // Recebe os gêneros selecionados
$nameImgmanga = $_FILES["nameImgmanga"];
$error = [];

// Data que o usuário inseriu o cadastro
$dateCadastre = date("Y-m-d H:i:s");

if (!empty($nameImgmanga["name"])) {
  $tamanho = 5000000; // Limite de tamanho em bytes

  if ($nameImgmanga["size"] > $tamanho) {
    $error[] = "O arquivo deve ter no máximo " . $tamanho . " bytes";
  }

  if (count($error) == 0) {
    // Verificar se a extensão do arquivo é uma imagem
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    preg_match("/\.(jpg|jpeg|png|gif)$/i", $nameImgmanga["name"], $ext);

    if (isset($ext[1]) && in_array($ext[1], $extensoesPermitidas)) {
      $nameImgmangaNew = md5(uniqid(time())) . "." . $ext[1];
      $caminho_img = "../arquivos_enviados_mangas/" . $nameImgmangaNew;

      if (move_uploaded_file($nameImgmanga["tmp_name"], $caminho_img)) {
        // Inserção no banco de dados
        $insere = new Insercao();

        $resultado = $insere->insertMangas(
          $mangaName,
          $synopsis,
          $volumes,
          $author,
          $mangaLink,
          $critictNote,
          $classification,
          $yearPublication,
          $dateCadastre,
          $nameImgmangaNew, // Passa o nome do arquivo gerado
          $mangaGenders
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
