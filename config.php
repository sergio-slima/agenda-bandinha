<?php
// credenciais do MySQL
$host = 'rccacailandia.com.br';
$db   = 'rccacail_bd';
$user = 'rccacail_user';
$pass = 'j9rKheqTOu0W';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Erro de conexão: '.$e->getMessage());
}

session_start();
