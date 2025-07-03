<?php
session_start();
include_once '../config/database.php';
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if (!isset($_GET['id'])) {
    echo "Comércio não especificado.";
    exit;
}

$comercio_id = $_GET['id'];

$stmtVerifica = $pdo->prepare("
    SELECT id, fachada, endereco 
    FROM comercios 
    WHERE id = :id AND criado_por = :usuario_id
");
$stmtVerifica->execute([
    ':id' => $comercio_id,
    ':usuario_id' => $usuario_id
]);
$comercio = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

if (!$comercio) {
    echo "Comércio inválido ou você não tem permissão para visualizar.";
    exit;
}

$stmtProdutos = $pdo->prepare("
    SELECT 
        pc.id AS vinculo_id,
        p.titulo,
        p.descricao,
        p.valor,
        p.foto,
        pc.vinculado_em
    FROM produtos_comercio pc
    INNER JOIN produtos p ON p.id = pc.produto_id
    WHERE pc.comercio_id = :comercio_id
    AND pc.status = 'aceito'
    ORDER BY pc.vinculado_em DESC
");

$stmtProdutos->execute([':comercio_id' => $comercio_id]);
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos Ativos no Comércio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .produto-card {
            background-color: white;
            border: 1px solid #007bff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);
        }
        .titulo-produto {
            color: #007bff;
        }
        .img-produto {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

    </style>
</head>
<body>

<div class="container my-4">
    <h2>Produtos Ativos - <?= htmlspecialchars($comercio['fachada']) ?></h2>

    <?php if (count($produtos) > 0): ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="produto-card">
                <div class="row">
                    <div class="col-md-3 d-flex">
                        <?php if (!empty($produto['foto'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($produto['foto']) ?>" alt="Foto do Produto" class="img-fluid img-produto rounded">
                        <?php else: ?>
                            <img src="" alt="Sem imagem" class="img-fluid img-produto rounded">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <h5 class="titulo-produto"><?= htmlspecialchars($produto['titulo']) ?></h5>
                        <p><?= htmlspecialchars($produto['descricao']) ?></p>
                        <p class="text-success fs-5">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
                        <p><small>Vinculado em: <?= htmlspecialchars($produto['vinculado_em']) ?></small></p>

                        <form method="get" action="processamentoSolicitacoes.php" class="mt-2">
                            <input type="hidden" name="vinculo_id" value="<?= $produto['vinculo_id'] ?>">
                            <button type="submit" name="acao" value="recusar" class="btn btn-outline-danger btn-sm">Remover do Comércio</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">Nenhum produto ativo neste comércio no momento.</div>
    <?php endif; ?>

    <a href="comercios.php" class="btn btn-secondary mt-3">Voltar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
