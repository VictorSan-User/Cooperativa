<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cooperativa de Caratinga</title>
        <link rel="icon" type="image/x-icon" href="#" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="index.php">Cooperativa</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= $_SERVER['PHP_SELF'] ?>"><i class="bi bi-house me-2"></i>Pagina Incial</a></li>
                        <li class="nav-item"><a class="nav-link" href="public/sobreNos.php"><i class="bi bi-info-circle-fill me-2"></i>About</a></li>
                        <li class="nav-item"><a class="nav-link" href="public/contatos.php"><i class="bi bi-telephone me-2"></i>Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="py-5">
            <div class="container px-lg-5">
                <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                    <img src="assets/logos/logo-200.png" alt="logo">
                    <div class="m-4 m-lg-5">
                        <h1 class="display-5 fw-bold">Conectando o campo à cidade!</h1>
                        <p class="fs-4">A Cooperativa de Produtores Rurais de Caratinga</p>
                        <a class="btn btn-primary btn-lg" href="consumidorFinal/index.php">Conheça os pontos de venda</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="pt-4">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5">
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-brightness-alt-high-fill"></i></i></div>
                                <h2 class="fs-4 fw-bold">Produtos frescos e locais</h2>
                                <p class="mb-0">Alimentos diretamente dos produtores rurais de Caratinga para sua mesa, com qualidade garantida!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-arrows-fullscreen"></i></div>
                                <h2 class="fs-4 fw-bold">Vários pontos de venda</h2>
                                <p class="mb-0">Encontre os produtos da cooperativa em mercados e estabelecimentos parceiros por toda a cidade.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-bag-fill"></i></div>
                                <h2 class="fs-4 fw-bold">Fortalecimento da economia local</h2>
                                <p class="mb-0">Consumindo da cooperativa, você apoia diretamente os produtores de nossa região!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-bar-chart-line-fill"></i></div>
                                <h2 class="fs-4 fw-bold">Sustentabilidade</h2>
                                <p class="mb-0">Menos transporte, menos poluição. Produtos locais geram menos impacto ambiental!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-award-fill"></i></div>
                                <h2 class="fs-4 fw-bold">Qualidade garantida</h2>
                                <p class="mb-0">Todos os produtos passam por um controle de qualidade feito pela própria cooperativa!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-patch-check"></i></div>
                                <h2 class="fs-4 fw-bold">Alimento com propósito</h2>
                                <p class="mb-0">Mais do que produtos, entregamos cuidado, trabalho e amor ao campo em cada alimento!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-2 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
