<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/estilo.css">
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
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Bem-vindo à Cooperativa!</h1>
        <p class="lead">Tudo em um único lugar! Veja nossas ofertas, encontre comércios parceiros e acompanhe seu carrinho.</p>
    </div>
    
    <div class="row g-4 text-center py-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ver Ofertas Ativas</h5>
                    <p class="card-text">Confira todos os produtos disponíveis para compra no momento.</p>
                    <a href="listaProdutos.php" class="btn btn-primary">Ver Produtos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ver Comércios Cadastrados</h5>
                    <p class="card-text">Encontre os estabelecimentos parceiros da cooperativa na sua cidade.</p>
                    <a href="listaComercios.php" class="btn btn-primary">Ver Comércios</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Meu Carrinho</h5>
                    <p class="card-text">Veja os produtos que você selecionou para comprar.</p>
                    <a href="carrinhoCompras.php" class="btn btn-primary">Acessar Carrinho</a>
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
