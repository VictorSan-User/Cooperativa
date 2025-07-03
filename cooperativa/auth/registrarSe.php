<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Cadastro - Cooperativa de Caratinga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="../index.php">Cooperativa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="../index.php"><i class="bi bi-house me-2"></i>Início</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/sobreNos.php"><i class="bi bi-info-circle-fill me-2"></i>Sobre Nós</a></li>
                <li class="nav-item"><a class="nav-link" href="../public/contatos.php"><i class="bi bi-telephone me-2"></i>Contato</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center">
                    <h4>Cadastro</h4>
                </div>
                <div class="card-body p-4">
                    <form action="autenticarNovoRegistro.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="João Silva">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Escolha seu melhor e-mail">
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
                        </div>
                        <div class="mb-3">
                            <label for="ConfirmSenha" class="form-label">Confirme sua senha:</label>
                            <input type="password" class="form-control" id="ConfirmSenha" name="ConfirmSenha" placeholder="Confirme sua senha">
                        </div>
                        <label for="ConfirmSenha" class="form-label">Se cadastrar como Produtor, Cliente ou Comerciante?</label>
                        <select name="tipo" class="form-select m-2">
                            <option value="produtor">Produtor</option>
                            <option value="comerciante">Comerciante</option>
                        </select>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        <?php 
                            if (isset($_SESSION['erro'])) {
                                echo '<div class="alert alert-danger text-center">'.$_SESSION['erro'].'</div>';
                                unset($_SESSION['erro']);
                            }
                        ?>
                        </div>
                    </form>
                    <a href="login.php" class="btn btn-secondary d-block mx-auto m-1">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-3 bg-dark fixed-bottom">
    <div class="container">
        <p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
