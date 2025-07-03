<?php
session_start();
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    //autenticacoes
    if(empty($email) || empty($senha)){
        header("Location: login.php");
        exit;
    }

    $verify = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $verify->execute(['email' => $email]);
    $usuario = $verify->fetch();
    
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        //caso exista, capturo as variaveis
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
       
        //direcionamento pra cada tipo de usuario
        switch ($_SESSION['usuario_tipo']) {
            case "produtor":
                header("Location: ../produtor/index.php");
                exit;
            case "comerciante":
                header("Location: ../comerciante/index.php"); //rota dos comerciantes
                exit;
            case "cliente":
                header("Location: ../cliente/index.php"); //rota dos clientes
                exit;
            default:
                // var_dump($_SESSION['usuario_tipo']);
                // exit;
                header("Location: ../produtor/index.php");
                exit;
        }
    } else {
        header('Location: login.php');
        exit;
    }

}else{
    header("Location: login.php");
    exit;
}