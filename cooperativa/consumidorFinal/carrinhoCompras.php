<?php
session_start();

include_once '../config/database.php';
include_once 'carrinho_functions.php';

// Adicionar ao carrinho via GET
if (isset($_GET['produto_id'])) {
    $produto_id = (int)$_GET['produto_id'];
    adicionarProdutoAoCarrinho($produto_id, 1);
    header("Location: carrinhoCompras.php");
    exit;
}

// Atualizar ou Remover via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'], $_POST['quantidade'])) {
    $produto_id = (int)$_POST['produto_id'];
    $quantidade = (int)$_POST['quantidade'];
    atualizarQuantidadeItem($produto_id, $quantidade);
    header("Location: carrinhoCompras.php");
    exit;
}

$itens = listarItensCarrinho($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - Cooperativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .produto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
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
    <h1 class="mb-4 text-primary">Meu Carrinho</h1>

    <?php if (count($itens) > 0): ?>
        <table class="table table-bordered align-middle bg-white shadow-sm">
            <thead class="table-secondary">
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total = 0;
                    foreach ($itens as $item): 
                        $subtotal = $item['preco_unitario'] * $item['quantidade'];
                        $total += $subtotal;
                ?>
                    <tr>
                        <td class="d-flex align-items-center gap-3">
                            <?php if (!empty($item['foto'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>" class="produto-img">
                            <?php else: ?>
                                <div class="produto-img bg-secondary d-flex justify-content-center align-items-center text-white">Sem foto</div>
                            <?php endif; ?>
                            <span><?php echo htmlspecialchars($item['nome']); ?></span>
                        </td>
                        <td>R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
                        <td style="width: 110px;">
                            <form method="post" action="carrinhoCompras.php" class="d-inline">
                                <input type="hidden" name="produto_id" value="<?php echo $item['produto_id']; ?>">
                                <input 
                                    type="number" 
                                    name="quantidade" 
                                    min="1" 
                                    value="<?php echo $item['quantidade']; ?>" 
                                    class="form-control form-control-sm d-inline" 
                                    style="width: 70px;"
                                >
                            </form>
                        </td>
                        <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <!-- Botão Atualizar -->
                                <form method="post" action="carrinhoCompras.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $item['produto_id']; ?>">
                                    <input type="hidden" name="quantidade" value="<?php echo $item['quantidade']; ?>" id="quantidade_<?php echo $item['produto_id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-primary w-100"
                                        onclick="
                                            event.preventDefault();
                                            var qtd = this.closest('tr').querySelector('input[name=quantidade]').value;
                                            this.closest('form').quantidade.value = qtd;
                                            this.closest('form').submit();
                                        ">
                                        Atualizar
                                    </button>
                                </form>

                                <!-- Botão Remover -->
                                <form method="post" action="carrinhoCompras.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $item['produto_id']; ?>">
                                    <input type="hidden" name="quantidade" value="0">
                                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Remover este item do carrinho?')">Remover</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th colspan="2" class="text-success fw-bold">R$ <?php echo number_format($total, 2, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="text-end">
            <a href="listaProdutos.php" class="btn btn-success">Continuar Comprando</a><br>
            <a href="index.php" class="btn btn-secondary px-5 mt-1">Voltar ao Início</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Seu carrinho está vazio.</div>
        <div class="text-center mt-4">
            <a href="listaProdutos.php" class="btn btn-primary px-5">Ver Produtos</a><br>
            <a href="index.php" class="btn btn-secondary mt-2 px-5">Voltar ao Início</a>
        </div>
    <?php endif; ?>
</div>

<footer class="py-2 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">&copy; Cooperativa de Caratinga/MG - <?= date('Y') ?></p></div>
</footer>

</body>
</html>
