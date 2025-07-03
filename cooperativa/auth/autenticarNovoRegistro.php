
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    if(empty($nome) || empty($email) || empty($senha)){
        $_SESSION['erro'] = "Preencha todos os campos.";
        header("Location: registrarSe.php");
        exit;
    }

    if($senha != $_POST['ConfirmSenha']){
        $_SESSION['erro'] = "As senhas precisam ser iguais.";
        header("Location: registrarSe.php");
        exit;
    }

    //confirmar se email ja tem no bd
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
    $check->execute(['email' => $email]);

    if($check->fetch()){
        $_SESSION['erro'] = "E-mail já cadastrado.";
        header("Location: registrarSe.php");
        exit;
    }

    //LGPD
    $senhaEncriptografada = password_hash($senha, PASSWORD_DEFAULT);

    //Inserindo no banco
    $novoRegistro = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo) ");

    try{
        $novoRegistro->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaEncriptografada,
            'tipo' => $tipo
        ]);
        $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
        header("Location: login.php");
        exit;
    }catch(PDOException $e){
        $erros = ["Erro ao cadastrar: "]. $e->getMessage();
        header("Location: registrarSe.php");
        exit;
    }

}else{
    header("Location: ../index.php");
    $_SESSION['erro'] = "Preencha todos os campos.";
    exit;
}