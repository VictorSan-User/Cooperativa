<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'produtor') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'] ?? null;
    $comercios = $_POST['comercios'] ?? [];

    if (empty($produto_id) || empty($comercios)) {
        header("Location: vincularProdutos.php");
        exit;
    }

    foreach ($comercios as $comercio_id) {
        // Verificar se já existe o vínculo
        $check = $pdo->prepare("SELECT * FROM produtos_comercio WHERE produto_id = :produto_id AND comercio_id = :comercio_id");
        $check->execute([
            ':produto_id' => $produto_id,
            ':comercio_id' => $comercio_id
        ]);

        if ($check->rowCount() == 0) {
            // Inserir o vínculo
            $stmt = $pdo->prepare("INSERT INTO produtos_comercio (produto_id, comercio_id, status) VALUES (:produto_id, :comercio_id, :status)");
            $stmt->execute([
                ':produto_id' => $produto_id,
                ':comercio_id' => $comercio_id,
                ':status' => 'pendente'
            ]);
        }
    }

    header("Location: index.php");
    exit;
} else {
    echo "Método de requisição inválido.";
}
?>
