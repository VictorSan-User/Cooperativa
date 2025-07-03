<?php
session_start();
include_once '../config/database.php';

if( !isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'produtor' ){
    header("Location: ../auth/login.php");
    exit;
}

$produtor_id = $_SESSION['usuario_id'];

if(!isset($_GET['id'])){
    echo "ID do produto não informado";
    exit;
}

$item_id = $_GET['id'];

$pesquisa = $pdo->prepare("SELECT * FROM produtos WHERE id = :id AND produtor_id = :produtor_id");
$pesquisa->execute([
    ':id' => $item_id,
    ':produtor_id' => $produtor_id
]);
$produtoEncontrado = $pesquisa->fetch(PDO::FETCH_ASSOC);

if(!$produtoEncontrado){
    echo "Produto não encontrado";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $valor = $_POST['valor'];

    $atualizacao = $pdo->prepare("UPDATE produtos SET titulo = :titulo, descricao = :descricao, valor = :valor WHERE id = :id AND produtor_id = :produtor_id");
    $atualizacao->execute([
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':valor' => $valor,
        ':id' => $item_id,
        ':produtor_id' => $produtor_id
    ]);
    header("Location: meusProdutos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">

    <div class="container mt-5">
        <div class="card shadow-sm border-primary">
            <div class="card-header bg-primary text-white">
                <h3>Editar Produto</h3>
            </div>
            <div class="card-body">

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $produtoEncontrado['titulo']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= $produtoEncontrado['descricao'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor (R$):</label>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="<?= $produtoEncontrado['valor'] ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <a href="meusProdutos.php" class="btn btn-outline-primary ms-2">Voltar</a>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
