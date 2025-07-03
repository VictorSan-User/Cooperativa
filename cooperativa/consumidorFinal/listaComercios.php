<?php

include_once '../config/database.php';

$sql = "SELECT comercios.*, usuarios.nome AS nome_comerciante 
        FROM comercios 
        JOIN usuarios ON comercios.criado_por = usuarios.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$comercios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comércios Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <link rel="stylesheet" href="../css/styles.css">

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
    <h1 class="mb-4 text-primary">Lojas Parceiras</h1>

    <?php if (count($comercios) > 0): ?>
        <div class="row g-4">
            <?php foreach ($comercios as $comercio): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <?php if (!empty($comercio['foto_fachada'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($comercio['foto_fachada']); ?>" class="card-img-top" alt="Foto da Loja">
                        <?php endif; ?>

                        <div class="card-body flex-grow-1 d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($comercio['fachada']); ?></h5>
                            <p class="text-muted mb-2"><strong>Endereço:</strong> <?php echo htmlspecialchars($comercio['endereco']); ?></p>
                            <p class="text-muted mb-4"><strong>Comerciante:</strong> <?php echo htmlspecialchars($comercio['nome_comerciante']); ?></p>

                            <div class="mt-auto text-center">
                                <a href="verComercio.php?id=<?php echo $comercio['id']; ?>" class="btn btn-primary btn-sm">Ver Produtos</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Nenhum comércio cadastrado no momento.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary px-5">Voltar</a>
    </div>
</div>

<footer class="py-2 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>

</body>
</html>
