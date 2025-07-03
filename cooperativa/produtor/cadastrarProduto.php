<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'produtor') {
    header("Location: ../auth/login.php");
    exit;
}

$respostaRuim = '';
$mensagemBoa = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $valor = $_POST['valor'];
    $produtor_id = $_SESSION['usuario_id'];

    // Variável para o nome da foto
    $foto_nome = null;

    // Tratamento do upload da imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $nome_original = $_FILES['foto']['name'];
        $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));

        if (in_array($extensao, $extensoes_permitidas)) {
            $novo_nome = uniqid('produto_', true) . '.' . $extensao;
            $caminho_destino = '../uploads/' . $novo_nome;

            if (!is_dir('../uploads')) {
                mkdir('../uploads', 0755, true);
            }

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_destino)) {
                $foto_nome = $novo_nome;
            } else {
                $respostaRuim = '<div class="alert alert-danger">Erro ao salvar a foto no servidor.</div>';
            }
        } else {
            $respostaRuim = '<div class="alert alert-danger">Formato de imagem inválido. Aceitos: JPG, JPEG, PNG, GIF.</div>';
        }
    } else {
        $respostaRuim = '<div class="alert alert-danger">Por favor, envie uma imagem do produto.</div>';
    }

    // Se tudo certo, insere no banco
    if (empty($respostaRuim) && !empty($foto_nome)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO produtos (titulo, descricao, valor, foto, produtor_id) VALUES (:titulo, :descricao, :valor, :foto, :produtor_id)");
            $stmt->execute([
                ':titulo' => $titulo,
                ':descricao' => $descricao,
                ':valor' => $valor,
                ':foto' => $foto_nome,
                ':produtor_id' => $produtor_id
            ]);
            $mensagemBoa = '<div class="alert alert-success">Produto cadastrado com sucesso!</div>';
            header("Location: meusProdutos.php");
            exit;
        } catch (PDOException $e) {
            $respostaRuim = '<div class="alert alert-danger">Erro ao salvar: ' . $e->getMessage() . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilo.css">

</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Cadastrar Novo Produto</h2>

    <?= $respostaRuim ?>
    <?= $mensagemBoa ?>

    <form action="" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="titulo" class="form-label">Nome do Produto</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor do Produto</label>
            <input type="number" step="0.01" name="valor" id="valor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto do Produto</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4 w-50">Cadastrar Novo Produto</button>
            <div>
                <a href="index.php" class="btn btn-secondary mt-2 px-4 w-50">Voltar</a>
            </div>
        </div>
    </form>
</div>
<footer class="py-2 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>
</body>
</html>
