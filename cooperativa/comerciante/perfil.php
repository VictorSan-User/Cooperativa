<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'comerciante' ) {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT nome, email, senha FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = trim($_POST['nome']);
    $novo_email = trim($_POST['email']);
    $nova_senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Validação básica
    if (empty($novo_nome) || empty($novo_email)) {
        $mensagem = "Nome e Email não podem ficar vazios.";
    } else {
        // Atualiza nome e email
        $params = [
            ':nome' => $novo_nome,
            ':email' => $novo_email,
            ':id' => $usuario_id
        ];

        $sql = "UPDATE usuarios SET nome = :nome, email = :email";

        // Se o usuário quiser trocar a senha
        if (!empty($nova_senha)) {
            if ($nova_senha === $confirmar_senha) {
                $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql .= ", senha = :senha";
                $params[':senha'] = $hash;
            } else {
                $mensagem = "As senhas não coincidem!";
            }
        }

        if (empty($mensagem)) {
            $sql .= " WHERE id = :id";
            $atualiza = $pdo->prepare($sql);
            $atualiza->execute($params);
            $mensagem = "Perfil atualizado com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <div class="col-6">
        <h2>Meu Perfil</h2>
    
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
    
        <form method="POST">
            <div class="mb-3">
                <label>Nome:</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>
    
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </div>
    
            <div class="mb-3">
                <label>Nova Senha (se quiser trocar):</label>
                <input type="password" name="senha" class="form-control">
            </div>
    
            <div class="mb-3">
                <label>Confirmar Nova Senha:</label>
                <input type="password" name="confirmar_senha" class="form-control">
            </div>
    
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

</body>
</html>
