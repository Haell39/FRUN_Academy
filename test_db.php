<?php
// F-RUM-ACADEMIA/test_db.php

// Inclui o arquivo de configuração do banco de dados
// O __DIR__ garante que o caminho seja absoluto, independentemente de onde este script for chamado
require_once __DIR__ . '/src/config/database.php';

// Se o script chegou até aqui sem "die()", significa que a conexão foi estabelecida com sucesso.
echo "<h1>Conexão com o banco de dados 'f_rum_academia' estabelecida com sucesso!</h1>";

// Opcional: Tentar fazer uma consulta simples para ter certeza
try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    echo "<p>Total de usuários na tabela: " . $result->total_users . "</p>";

    $stmt = $pdo->query("SELECT apelido, email FROM users LIMIT 2");
    echo "<h2>Alguns usuários:</h2>";
    echo "<ul>";
    while ($user = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo "<li>Apelido: " . htmlspecialchars($user->apelido) . " | Email: " . htmlspecialchars($user->email) . "</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "<p>Erro ao executar consulta de teste: " . $e->getMessage() . "</p>";
}

?>