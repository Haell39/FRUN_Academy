<?php
// src/config/database.php

// Defina as credenciais do seu banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'f_rum_academia'); // <<--- Mantenha este nome de banco, ou mude se preferir outro!
define('DB_USER', 'root');           // <<--- Seu usuário do MySQL
define('DB_PASS', '2025TI');         // <<--- Sua senha do MySQL!
define('DB_CHARSET', 'utf8mb4');

// Bloco para tentar a conexão com o banco de dados
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
}
?>