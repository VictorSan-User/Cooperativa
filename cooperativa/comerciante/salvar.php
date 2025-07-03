<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'comerciante') {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fachada = trim($_POST['fachada']);
    $endereco = trim($_POST['endereco']);
    $id_comercio = $_POST['id'] ?? null; 

    if (empty($fachada) || empty($endereco)) {
        $_SESSION['erro'] = "Preencha todos os campos.";
        header("Location: novoComercio.php" . ($id_comercio ? "?id=$id_comercio" : ""));
        exit;
    }

    $queryDup = "SELECT * FROM comercios WHERE endereco = :endereco";
    $paramsDup = [':endereco' => $endereco];

    if ($id_comercio) {
        $queryDup .= " AND id != :id";
        $paramsDup[':id'] = $id_comercio;
    }

    $busca = $pdo->prepare($queryDup);
    $busca->execute($paramsDup);
    $existe = $busca->fetch(PDO::FETCH_ASSOC);

    if ($existe) {
        $_SESSION['erro'] = "Já existe um comércio com esse endereço.";
        header("Location: novoComercio.php" . ($id_comercio ? "?id=$id_comercio" : ""));
        exit;
    }

    // Upload da foto da fachada
    $fotoFachadaNome = null;
    if (isset($_FILES['foto_fachada']) && $_FILES['foto_fachada']['error'] == UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto_fachada']['name'], PATHINFO_EXTENSION);
        $fotoFachadaNome = uniqid('fachada_') . "." . $extensao;
        move_uploaded_file($_FILES['foto_fachada']['tmp_name'], "../uploads/" . $fotoFachadaNome);
    }

    if ($id_comercio) {
        if (!$fotoFachadaNome) {
            $stmtAtual = $pdo->prepare("SELECT foto_fachada FROM comercios WHERE id = :id AND criado_por = :criado_por");
            $stmtAtual->execute([':id' => $id_comercio, ':criado_por' => $usuario_id]);
            $dadosAtuais = $stmtAtual->fetch(PDO::FETCH_ASSOC);
            $fotoFachadaNome = $dadosAtuais['foto_fachada'];
        }

        $stmt = $pdo->prepare("UPDATE comercios SET fachada = :fachada, endereco = :endereco, foto_fachada = :foto_fachada WHERE id = :id AND criado_por = :criado_por");
        $stmt->execute([
            ':fachada' => $fachada,
            ':endereco' => $endereco,
            ':foto_fachada' => $fotoFachadaNome,
            ':id' => $id_comercio,
            ':criado_por' => $usuario_id
        ]);
        $_SESSION['sucesso'] = "Comércio atualizado com sucesso!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO comercios (fachada, endereco, foto_fachada, criado_por) VALUES (:fachada, :endereco, :foto_fachada, :criado_por)");
        $stmt->execute([
            ':fachada' => $fachada,
            ':endereco' => $endereco,
            ':foto_fachada' => $fotoFachadaNome,
            ':criado_por' => $usuario_id
        ]);
        $_SESSION['sucesso'] = "Comércio cadastrado com sucesso!";
    }

    header("Location: comercios.php");
    exit;
}

$_SESSION['erro'] = "Requisição inválida.";
header("Location: comercios.php");
exit;
?>
