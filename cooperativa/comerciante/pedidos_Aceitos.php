<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar os dados do comércio, incluindo a foto_fachada
$stmtComercio = $pdo->prepare("SELECT id, fachada, endereco, foto_fachada FROM comercios WHERE criado_por = :usuario_id");
$stmtComercio->execute([':usuario_id' => $usuario_id]);
$comercio = $stmtComercio->fetch(PDO::FETCH_ASSOC);

if (!$comercio) {
    echo "Nenhum comércio encontrado para este comerciante.";
    exit;
}

$comercio_id = $comercio['id'];

// Buscar os produtos vinculados
$stmtProdutos = $pdo->prepare("
    SELECT p.id, p.titulo, p.descricao, p.valor, pc.vinculado_em, p.foto
    FROM produtos p
    INNER JOIN produtos_comercio pc ON p.id = pc.produto_id
    WHERE pc.comercio_id = :comercio_id
    ORDER BY pc.vinculado_em DESC
");
$stmtProdutos->execute([':comercio_id' => $comercio_id]);
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos no Meu Comércio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(202, 241, 209);
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
        .fachada-img {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container my-4">

    <h1 class="text-success">Produtos À Venda no Comércio:</h1>

    <!-- Exibir foto da fachada -->
    <?php if (!empty($comercio['foto_fachada'])): ?>
        <div class="mb-4">
            <img src="../uploads/<?= htmlspecialchars($comercio['foto_fachada']) ?>" alt="Foto da Fachada" class="fachada-img">
        </div>
    <?php endif; ?>

    <?php if (count($produtos) > 0): ?>
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4">
                    <div class="produto-card">
                        <?php if (!empty($produto['foto'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($produto['foto']) ?>" alt="Foto do produto" class="img-fluid rounded mt-2">
                        <?php endif; ?>
                        <h4 class="text-dark fs-3"><?= htmlspecialchars($comercio['fachada']) ?></h4>
                        <h4 class="titulo-produto"><?= htmlspecialchars($produto['titulo']) ?></h4>
                        <p><?= htmlspecialchars($produto['descricao']) ?></p>
                        <p><strong>Endereço:</strong> <?= htmlspecialchars($comercio['endereco']) ?></p>
                        <p><div class="text-success text-end fs-5">R$ <?= htmlspecialchars(number_format($produto['valor'], 2, ',', '.')) ?></div></p>
                        <p><small class="text-muted">Vinculado em: <?= date('d/m/Y H:i', strtotime($produto['vinculado_em'])) ?></small></p>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Nenhum produto vinculado a este comércio.
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Voltar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
