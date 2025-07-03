<?php

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Adicionar produto ao carrinho
function adicionarProdutoAoCarrinho(int $produto_id, int $quantidade = 1) {
    if (isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id] += $quantidade;
    } else {
        $_SESSION['carrinho'][$produto_id] = $quantidade;
    }
}

// Listar itens do carrinho (aqui, vamos buscar os dados reais do produto no banco, como nome e valor)
function listarItensCarrinho(PDO $pdo): array {
    $itens = [];

    foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
        // Busca os detalhes do produto no banco
        $stmt = $pdo->prepare("SELECT titulo AS nome, valor, foto FROM produtos WHERE id = :produto_id");
        $stmt->execute(['produto_id' => $produto_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $itens[] = [
                'produto_id' => $produto_id,
                'nome' => $produto['nome'],
                'foto' => $produto['foto'],
                'quantidade' => $quantidade,
                'preco_unitario' => $produto['valor'],
                'subtotal' => $produto['valor'] * $quantidade
            ];
        }
    }

    return $itens;
}

function atualizarQuantidadeItem(int $produto_id, int $nova_quantidade) {
    if ($nova_quantidade <= 0) {
        unset($_SESSION['carrinho'][$produto_id]);
    } else {
        $_SESSION['carrinho'][$produto_id] = $nova_quantidade;
    }
}

// Remover item do carrinho
function removerItemDoCarrinho(int $produto_id) {
    unset($_SESSION['carrinho'][$produto_id]);
}

// Limpar o carrinho inteiro
function limparCarrinho() {
    $_SESSION['carrinho'] = array();
}
?>
