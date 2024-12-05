<?php
require_once '../Classes/Insercao.php';

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário, ajuste conforme necessário

$hqName = $_POST["tituloHq"];
$synopsis = $_POST["sinopseHq"];
$pagesNumber = $_POST["numPaginasHq"];
$author = $_POST["autoresHq"];
$hqLink = $_POST["linkCompraHq"];
$critictNote = $_POST["avaliacaoHq"];
$classification = $_POST["classificacaoHq"];
$yearPublication = $_POST["AnoLancamentoHq"];
$hqGenders = $_POST["generohq"] ?? []; // Recebe os gêneros selecionados
$nameImgHq = $_FILES["imagemHq"];
$error = [];

// Data que o usuário inseriu o cadastro
$dateCadastre = date("Y-m-d H:i:s");

if (!empty($nameImgHq["name"])) {
  $tamanho = 5000000; // Limite de tamanho em bytes

  if ($nameImgHq["size"] > $tamanho) {
    $error[] = "O arquivo deve ter no máximo " . $tamanho . " bytes";
  }

  if (count($error) == 0) {
    // Verificar se a extensão do arquivo é uma imagem
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    preg_match("/\.(jpg|jpeg|png|gif)$/i", $nameImgHq["name"], $ext);

    if (isset($ext[1]) && in_array($ext[1], $extensoesPermitidas)) {
      $nameImgHqNew = md5(uniqid(time())) . "." . $ext[1];
      $caminho_img = "../arquivos_enviados_hq/" . $nameImgHqNew;

      if (move_uploaded_file($nameImgHq["tmp_name"], $caminho_img)) {
        // Inserção no banco de dados
        $insere = new Insercao();

        $resultado = $insere->insertHq(
          $hqName,
          $synopsis,
          $pagesNumber,
          $author,
          $hqLink,
          $critictNote,
          $classification,
          $yearPublication,
          $dateCadastre,
          $nameImgHqNew,
          $hqGenders
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
}
?>
