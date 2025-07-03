<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'produtor') {
    header("Location: ../auth/login.php");
    exit;
}

$produtor_id = $_SESSION['usuario_id'];

$busca = $pdo->prepare("SELECT * FROM produtos WHERE produtor_id = :produtor_id ORDER BY criado_em DESC");
$busca->execute(['produtor_id' => $produtor_id]);
$produtos = $busca->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilo.css">

    <style>
        .produto-img {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-primary mb-4">Meus Produtos</h2>

    <?php if (empty($produtos)): ?>
        <div class="alert alert-warning">Você ainda não cadastrou nenhum produto.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        
                        <?php if (!empty($produto['foto']) && file_exists('../uploads/' . $produto['foto'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($produto['foto']) ?>" class="card-img-top produto-img" alt="Foto do Produto">
                        <?php else: ?>
                            <img src="../assets/img/sem-imagem.png" class="card-img-top produto-img" alt="Sem imagem">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produto['titulo']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
                            <p class="card-text text-success fw-bold">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
                        </div>
                        <div class="card-footer text-end bg-white border-0">
                            <a href="atualizarProduto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="excluirProduto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center pb-5">
        <a href="cadastrarProduto.php" class="btn btn-primary mt-4 w-50">Cadastrar Novo Produto</a>
        <div class="pb-5">
            <a href="index.php" class="btn btn-secondary mt-2 px-4 w-50">Voltar</a>
        </div>
    </div>
</div>
<footer class="py-2 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>
</body>
</html>
