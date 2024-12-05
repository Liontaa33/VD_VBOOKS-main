<?php
ob_start();
require_once '../Classes/Selecao.php';

$email = $_POST['email'];
$email = strtoupper($email);
$pass = $_POST['pass'];

$email = stripcslashes($email);
$pass = stripcslashes($pass);

$busca = new Selecao();
$result = $busca->selecionarLogin($email, $pass);
$id = $result->qtd;

if ($id >= 1) {
    session_start();
    $_SESSION['id_users'] = $result->id_users;
    $_SESSION['email'] = $result->email;
    $_SESSION['name'] = $result->name;
    $_SESSION['pass'] = $result->pass;
    $_SESSION['age'] = $result->age;
    $_SESSION['permission_id'] = $result->permission_id;



    header("Location: ../index.php");
    exit;
} else {
    echo "Sem acesso";
}

ob_end_flush();
