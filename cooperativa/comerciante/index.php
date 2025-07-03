<?php
session_start();

include_once '../config/database.php';

// Verifica se o usuário é comerciante
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$comercianteId = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM comercios WHERE criado_por = ?");
$stmt->execute([$comercianteId]);
$totalComercios = $stmt->fetchColumn();

$buscaProdutos = $pdo->prepare("
    SELECT COUNT(*) AS total
    FROM produtos_comercio pc
    INNER JOIN comercios c ON pc.comercio_id = c.id
    WHERE pc.status = 'aceito'
    AND c.criado_por = :comerciante_id
");
$buscaProdutos->execute([':comerciante_id' => $comercianteId]);

$totalProdutosVinculados = $buscaProdutos->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel do Comerciante</title>
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
        .card-summary {
            background-color: #0d6efd;
            color: white;
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
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h1>
        <p class="lead">Você está no painel de <strong><?= $_SESSION['usuario_tipo']; ?></strong>. Aqui você pode gerenciar seu(s) comércio(s).</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card card-summary p-3">
                <h5>Comércios cadastrados</h5>
                <h2><?= $totalComercios ?></h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-summary p-3">
                <h5>Produtos vinculados</h5>
                <h2><?= $totalProdutosVinculados['total'] ?></h2>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>