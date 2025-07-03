<?php
session_start();
include_once '../config/database.php';

if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'produtor'){
    header("Location: ../auth/login.php");
    exit;
}

$item_id = $_GET['id'];
$produtor_id = $_SESSION['usuario_id'];

$pesquisa = $pdo->prepare("SELECT *FROM produtos WHERE id = :id AND produtor_id = :produtor_id");
$pesquisa->execute([
    ':id' => $item_id,
    ':produtor_id' => $produtor_id
]);
$resultado = $pesquisa->fetch(PDO::FETCH_ASSOC);

if(!$resultado){
    echo "Nao foi encontrado o produto a ser excluido";
    exit;
}        

$delete = $pdo->prepare("DELETE FROM produtos WHERE id = :id AND produtor_id = :produtor_id");
$delete->execute([
    ':id' => $item_id,
    ':produtor_id' => $produtor_id
]);
header("Location: meusProdutos.php");
exit;
?>