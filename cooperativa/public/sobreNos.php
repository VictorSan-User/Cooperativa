<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sobre Nós - Cooperativa Caratinga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-lg-5">
            <a class="navbar-brand" href="#">Cooperativa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php"><i class="bi bi-house me-2"></i>Pagina Incial</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $_SERVER['PHP_SELF'] ?>"><i class="bi bi-info-circle-fill me-2"></i>About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contatos.php"><i class="bi bi-telephone me-2"></i>Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="py-5 bg-light">
        <div class="container px-lg-5 text-center text-primary">
            <h1 class="fw-bold">Quem somos</h1>
            <p class="lead">Conheça a história e os valores da nossa cooperativa</p>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-lg-5 text-primary">
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        Fundada por agricultores locais de Caratinga/MG, a Cooperativa de Produtores Rurais nasceu com o propósito de fortalecer a agricultura familiar e aproximar o produtor do consumidor final.
                    </p>
                    <p>
                        Ao longo dos anos, desenvolvemos expertise em práticas sustentáveis de plantio, colheita e beneficiamento. Através da nossa rede de pontos de venda parceiros, garantimos que alimentos frescos e de qualidade cheguem às famílias da cidade.
                    </p>
                    <p>
                        Acreditamos na cooperação como motor de transformação social e econômica. Juntos, geramos renda, promovemos saúde e valorizamos o que é nosso.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-3 bg-dark text-white fixed-bottom">
        <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
