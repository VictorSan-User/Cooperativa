<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'produtor') {
    header("Location: ../auth/login.php");
    exit;
}

$produtor_id = $_SESSION['usuario_id'];

$stmtProdutos = $pdo->prepare("SELECT * FROM produtos WHERE produtor_id = :produtor_id");
$stmtProdutos->execute(['produtor_id' => $produtor_id]);
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

$stmtComercios = $pdo->query("SELECT * FROM comercios");
$comercios = $stmtComercios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Vincular Produtos às Lojas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilo.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 40px;
        }
        .card {
            border: 1px solid #0d6efd;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
        .form-check-label {
            margin-left: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h4>Vínculo com Lojas Certificadas</h4>
        </div>
        <div class="card-body">
            <form action="processamento.php" method="POST">

                <!-- Seleção de Produto -->
                <div class="mb-3">
                    <label for="produto" class="form-label">Selecione seu Produto:</label>
                    <select class="form-select" id="produto" name="produto_id" required>
                        <option value="">Escolha um Produto</option>
                        <?php foreach($produtos as $produto): ?>
                            <option value="<?= $produto['id'] ?>"><?= htmlspecialchars($produto['titulo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Lista de Estabelecimentos -->
                <div class="mb-3">
                    <label class="form-label">Escolha o(s) estabelecimento(s):</label>
                    <?php foreach($comercios as $comercio): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="comercios[]" value="<?= $comercio['id'] ?>" id="comercio<?= $comercio['id'] ?>">
                            <label class="form-check-label" for="comercio<?= $comercio['id'] ?>">
                                <?= htmlspecialchars($comercio['fachada']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary">Vincular Produto</button>
                <a href="index.php" class="btn btn-secondary">Voltar ao Painel</a>

            </form>
        </div>
    </div>
</div>
<footer class="py-2 bg-light">
    <hr>
    <div class="container"><p class="m-0 text-center text-dark">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>
</body>
</html>
