<?php
include_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Comércio inválido.");
}

$comercio_id = (int)$_GET['id'];
$termo = $_GET['busca'] ?? '';

// Buscar comércio para exibir nome na página
$stmt = $pdo->prepare("SELECT fachada FROM comercios WHERE id = :id");
$stmt->execute(['id' => $comercio_id]);
$comercio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comercio) {
    die("Comércio não encontrado.");
}

// Buscar produtos com status 'aceito' para esse comércio (com filtro de busca se houver)
$sql = "
    SELECT 
        p.id AS produto_id,
        p.titulo AS produto_nome,
        p.descricao AS produto_descricao,
        p.foto AS produto_imagem,
        p.valor AS produto_preco,
        c.id AS comercio_id,
        c.fachada AS comercio_nome
    FROM produtos p
    JOIN produtos_comercio pc ON p.id = pc.produto_id
    JOIN comercios c ON pc.comercio_id = c.id
    WHERE pc.comercio_id = :comercio_id
    AND pc.status = 'aceito'
";

$params = ['comercio_id' => $comercio_id];

if (!empty($termo)) {
    $sql .= " AND p.titulo LIKE :busca";
    $params['busca'] = '%' . $termo . '%';
}

$stmtProdutos = $pdo->prepare($sql);
$stmtProdutos->execute($params);
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos Disponíveis - <?php echo htmlspecialchars($comercio['fachada']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="mb-4 text-primary">Ofertas Ativas - <?php echo htmlspecialchars($comercio['fachada']); ?></h1>

    <!-- Formulário de pesquisa -->
    <form method="get" class="mb-4">
        <input type="hidden" name="id" value="<?php echo $comercio_id; ?>">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar produto por nome" value="<?= htmlspecialchars($termo) ?>">
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
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($produto['produto_descricao'])); ?></p>
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
        <div class="alert alert-info">
            Nenhum produto encontrado<?php if ($termo) echo " para \"".htmlspecialchars($termo)."\""; ?>.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="listaComercios.php" class="btn btn-secondary px-5">Voltar</a>
    </div>
</div>

<footer class="py-3 mt-5 text-dark bg-light border-top">
    <div class="container text-center">
        <p class="m-0">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p>
    </div>
</footer>

</body>
</html>
