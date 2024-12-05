<?php 
    require_once '../Classes/Insercao.php';

    date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário, ajuste conforme necessário

  //Capturando os dados que vem do formulario
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $age = $_POST['age'];
    $permissionId = 2;

  //Pega a data do momento do cadastro
    $dateCadastre = date("Y-m-d H:i:s");

    $insere = new Insercao();

    $resultado = $insere->insertUsers(
        $email,
        $name,
        $pass,
        $age,
        $permissionId,
        $dateCadastre
    );

// Redirecionamento para uma página específica
header("Location: ../Success/sucesso.html");
exit;
