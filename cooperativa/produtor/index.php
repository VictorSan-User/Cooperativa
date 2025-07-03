<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'produtor'){
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Produtor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Cooperativa - Produtor</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../auth/logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h1>
        <p class="lead">Você está no painel de <strong><?= $_SESSION['usuario_tipo']; ?></strong>. Aqui você pode gerenciar seus produtos.</p>
    </div>
    <div class="row g-4 text-center py-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Cadastrar Produto</h5>
                    <p class="card-text">Adicione novos produtos com descrição e imagem.</p>
                    <a href="cadastrarProduto.php" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Meus Produtos</h5>
                    <p class="card-text">Visualize, altere ou exclua seus produtos cadastrados.</p>
                    <a href="meusProdutos.php" class="btn btn-primary">Ver produtos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Vincular a Comércios</h5>
                    <p class="card-text">Escolha onde seus produtos serão vendidos na cidade.</p>
                    <a href="vincularProdutos.php" class="btn btn-primary">Vincular</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-2 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>

</body>
</html>