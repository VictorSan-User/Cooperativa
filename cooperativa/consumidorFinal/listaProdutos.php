<?php
include_once '../config/database.php';

$termo = $_GET['busca'] ?? '';

// Buscar todos os produtos vinculados com status aceito (com filtro se houver busca)
$sql = "
    SELECT 
        p.id AS produto_id,
        p.titulo AS produto_nome,
        p.descricao AS produto_descricao,
        p.foto AS produto_imagem,
        p.valor AS produto_preco,
        c.fachada AS comercio_nome,
        c.id AS comercio_id
    FROM produtos_comercio pc
    JOIN produtos p ON pc.produto_id = p.id
    JOIN comercios c ON pc.comercio_id = c.id
    WHERE pc.status = 'aceito'
";

if (!empty($termo)) {
    $sql .= " AND p.titulo LIKE :busca";
}

$stmt = $pdo->prepare($sql);

if (!empty($termo)) {
    $stmt->bindValue(':busca', '%' . $termo . '%', PDO::PARAM_STR);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Cooperativa</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="nav-link px-4" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-light text-dark px-4" href="../auth/login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h1 class="mb-4 text-primary">Ofertas Ativas</h1>

    <!-- Formulário de pesquisa -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar por nome do produto" value="<?= htmlspecialchars($termo) ?>">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
    </form>

    <?php if (count($produtos) > 0): ?>
        <div class="row g-4">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <?php if (!empty($produto['produto_imagem'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($produto['produto_imagem']); ?>" class="card-img-top" alt="Imagem do Produto">
                        <?php endif; ?>

                        <div class="card-body flex-grow-1 d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['produto_nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($produto['produto_descricao']); ?></p>
                            <p><strong>Disponível em:</strong> <?php echo htmlspecialchars($produto['comercio_nome']); ?></p>
                            <p class="fw-bold text-success">R$ <?php echo number_format($produto['produto_preco'], 2, ',', '.'); ?></p>
                        </div>

                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                            <a href="verComercio.php?id=<?php echo $produto['comercio_id']; ?>" class="btn btn-primary btn-sm">Ver Loja</a>
                            <a href="carrinhoCompras.php?produto_id=<?php echo $produto['produto_id']; ?>" class="btn btn-success btn-sm">Adicionar ao Carrinho</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Nenhum produto disponível<?php if ($termo) echo " para \"".htmlspecialchars($termo)."\""; ?>.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary px-5">Voltar</a>
    </div>
</div>

<footer class="py-2 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p>
    </div>
</footer>

</body>
</html>
