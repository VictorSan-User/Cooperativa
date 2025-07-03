<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $acao = $_GET['acao'] ?? '';
    $vinculo_id = $_GET['id'] ?? '';

    if (empty($acao) || empty($vinculo_id)) {
        echo "Parâmetros inválidos.";
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];

    $stmtComercios = $pdo->prepare("SELECT id FROM comercios WHERE criado_por = :usuario_id");
    $stmtComercios->execute([':usuario_id' => $usuario_id]);
    $comercios = $stmtComercios->fetchAll(PDO::FETCH_COLUMN);

    if (empty($comercios)) {
        echo "Nenhum comércio encontrado.";
        exit;
    }

    if ($acao === 'aceitar') {
        $placeholders = implode(',', array_fill(0, count($comercios), '?'));
        $sql = "UPDATE produtos_comercio SET status = 'aceito' WHERE id = ? AND comercio_id IN ($placeholders)";
        $params = array_merge([$vinculo_id], $comercios);
        $update = $pdo->prepare($sql);
        $update->execute($params);

        $update->execute(array_merge([$vinculo_id], $comercios));
    } elseif ($acao === 'recusar') {
        $placeholders = implode(',', array_fill(0, count($comercios), '?'));
        $sql = "UPDATE produtos_comercio SET status = 'recusado' WHERE id = ? AND comercio_id IN ($placeholders)";
        $params = array_merge([$vinculo_id], $comercios);
        $delete = $pdo->prepare($sql);
        $delete->execute($params);
    } else {
        echo "Ação inválida.";
        exit;
    }

    header("Location: solicitacoesPendentes.php");
    exit;

} else {
    echo "Requisição inválida.";
    exit;
}
?>
