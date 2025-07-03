<?php
$host = 'localhost';
$db   = 'cooperativa';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,// exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// resultados como arrays associativos
    PDO::ATTR_EMULATE_PREPARES   => false,// prepares nativos (mais seguros)
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Erro de conexão com banco de dados: " . $e->getMessage();
    exit;
}