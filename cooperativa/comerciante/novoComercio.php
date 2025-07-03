<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$comerciante_id = $_SESSION['usuario_id'];
$modoEdicao = false;
$comercio = [
    'fachada' => '',
    'foto_fachada' => '',
    'endereco' => ''
];

if (isset($_GET['id'])) {
    $modoEdicao = true;
    $stmt = $pdo->prepare("SELECT * FROM comercios WHERE id = :id AND criado_por = :criado_por");
    $stmt->execute([
        'id' => $_GET['id'],
        'criado_por' => $comerciante_id
    ]);
    $comercio = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$comercio) {
        echo "Comércio não encontrado.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $modoEdicao ? 'Editar' : 'Cadastrar' ?> Comércio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        main {
            margin-left: 220px;
            padding: 20px;
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
    <h1><?= $modoEdicao ? 'Editar Comércio' : 'Cadastrar Novo Comércio' ?></h1>

    <form action="salvar.php" method="POST" enctype="multipart/form-data" class="mt-4">

        <?php if ($modoEdicao): ?>
            <input type="hidden" name="id" value="<?= $comercio['id'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Comércio</label>
            <input type="text" name="fachada" id="fachada" class="form-control" required value="<?= htmlspecialchars($comercio['fachada']) ?>">
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control" required value="<?= htmlspecialchars($comercio['endereco']) ?>">
        </div>

        <div class="mb-3">
            <label for="foto_fachada" class="form-label">Foto da Fachada <?= $modoEdicao && $comercio['foto_fachada'] ? '(Deixe vazio para manter a atual)' : '' ?></label>
            <input type="file" name="foto_fachada" id="foto_fachada" class="form-control">

            <?php if ($modoEdicao && !empty($comercio['foto_fachada']) && file_exists('../uploads/' . $comercio['foto_fachada'])): ?>
                <p class="mt-2">Imagem atual:</p>
                <img src="../uploads/<?= htmlspecialchars($comercio['foto_fachada']) ?>" alt="Fachada atual" style="max-width:200px;">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success"><?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Comércio' ?></button>
        <a href="comercios.php" class="btn btn-secondary">Cancelar</a>

    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
