<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

// Pega o id do comércio via GET
$id_comercio = $_GET['id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

if (!$id_comercio) {
    $_SESSION['erro'] = "ID do comércio não informado.";
    header("Location: comercios.php");
    exit;
}

$pesquisa = $pdo->prepare("SELECT * FROM comercios WHERE id = :id AND criado_por = :criado_por");
$pesquisa->execute([
    ':id' => $id_comercio,
    ':criado_por' => $usuario_id
]);
$resultado = $pesquisa->fetch(PDO::FETCH_ASSOC);

if (!$resultado) {
    $_SESSION['erro'] = "Comércio não encontrado ou acesso negado.";
    header("Location: comercios.php");
    exit;
}

// Exclui o comércio
$exclusao = $pdo->prepare("DELETE FROM comercios WHERE id = :id AND criado_por = :criado_por");
$exclusao->execute([
    ':id' => $id_comercio,
    ':criado_por' => $usuario_id
]);

$_SESSION['sucesso'] = "Comércio excluído com sucesso.";
header("Location: comercios.php");
exit;
