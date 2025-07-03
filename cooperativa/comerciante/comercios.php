<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_SESSION['usuario_id'];

$buscaPreco = $pdo->prepare("SELECT * FROM produtos ");
$busca = $pdo->prepare("SELECT * FROM comercios WHERE criado_por = :user_id ORDER BY criado_em DESC");
$busca->execute([':user_id' => $user_id]);

$comercios = $busca->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meus Comércios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-width: 220px;
            height: 100vh;
            background-color: #0d6efd;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: white;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #0b5ed7;
            color: white;
        }
        main {
            margin-left: 220px;
            padding: 20px;
        }
        .card-comercio img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <a href="index.php" class="active">Dashboard</a>
    <a href="comercios.php">Meus Comércios</a>
    <a href="solicitacoesPendentes.php">Solicitações de Vinculação</a>
    <a href="perfil.php">Perfil</a>
    <a href="../auth/logout.php">Sair</a>
</div>

<main>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Meus Comércios</h1>
        <a href="novoComercio.php" class="btn btn-primary">+ Novo Comércio</a>
    </div>
    <?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-danger py-2">
        <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="alert alert-success py-2">
            <?= htmlspecialchars($_SESSION['sucesso']) ?>
        </div>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>
    <?php if (count($comercios) === 0): ?>
        <div class="alert alert-info">
            Nenhum comércio cadastrado ainda.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($comercios as $comercio): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-comercio shadow-sm">
                        <?php if (!empty($comercio['fachada'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($comercio['foto_fachada']) ?>" alt="Fachada <?= htmlspecialchars($comercio['fachada']) ?>" class="card-img-top" />
                        <?php else: ?>
                            <div style="height:150px;background:#dee2e6;display:flex;align-items:center;justify-content:center;color:#6c757d;">
                                Sem imagem
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($comercio['fachada']) ?></h5>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($comercio['endereco']) ?></small></p>
                            <!-- <h5 class="card-title"><?= htmlspecialchars($comercio['valor']) ?></h5> -->
                            <a href="produtos_vinculados.php?id=<?= $comercio['id'] ?>" class="btn btn-sm btn-primary">Ver Produtos</a>
                            <a href="novoComercio.php?id=<?= $comercio['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="excluir_comercio.php?id=<?= $comercio['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este comércio?');">Excluir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
