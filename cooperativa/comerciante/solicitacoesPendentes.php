<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmtComercios = $pdo->prepare("SELECT id, fachada FROM comercios WHERE criado_por = :usuario_id");
$stmtComercios->execute([':usuario_id' => $usuario_id]);
$comercios = $stmtComercios->fetchAll(PDO::FETCH_ASSOC);

if (count($comercios) === 0) {
    echo "<div style='margin: 20px; font-family: Arial; color: #555;'>Nenhum comércio encontrado para este comerciante.</div>";
    exit;
}

// Criar placeholders para o IN
$comercio_ids = array_column($comercios, 'id');
$placeholders = implode(',', array_fill(0, count($comercio_ids), '?'));

// Buscar as solicitações pendentes com o nome do produtor
$sql = "
    SELECT 
        pc.id AS vinculo_id,
        p.titulo,
        p.descricao,
        pc.vinculado_em,
        c.fachada,
        u.nome AS nome_produtor
    FROM produtos_comercio pc
    INNER JOIN produtos p ON p.id = pc.produto_id
    INNER JOIN usuarios u ON u.id = p.produtor_id
    INNER JOIN comercios c ON c.id = pc.comercio_id
    WHERE pc.comercio_id IN ($placeholders)
    AND pc.status = 'pendente'
    ORDER BY pc.vinculado_em DESC
";

$stmtProdutos = $pdo->prepare($sql);
$stmtProdutos->execute($comercio_ids);
$pendentes = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Solicitações Pendentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h1>Solicitações Pendentes - Meus Comércios</h1>

<?php if (count($pendentes) === 0): ?>
    <div class="alert alert-info">Nenhuma solicitação pendente no momento.</div>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Produtor</th>
                <th>Produto</th>
                <th>Descrição</th>
                <th>Data da Solicitação</th>
                <th>Comércio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendentes as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['nome_produtor']) ?></td>
                    <td><?= htmlspecialchars($pedido['titulo']) ?></td>
                    <td><?= htmlspecialchars($pedido['descricao']) ?></td>
                    <td><?= htmlspecialchars($pedido['vinculado_em']) ?></td>
                    <td><?= htmlspecialchars($pedido['fachada']) ?></td>
                    <td>
                        <a href="processamentoSolicitacoes.php?id=<?= $pedido['vinculo_id'] ?>&acao=aceitar" class="btn btn-success btn-sm">Aceitar</a>
                        <a href="processamentoSolicitacoes.php?id=<?= $pedido['vinculo_id'] ?>&acao=recusar" class="btn btn-danger btn-sm">Recusar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="index.php" class="btn btn-secondary mt-3">Voltar</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
