<?php
// F-RUM-ACADEMIA/Cadastro/cadastro.php

session_start(); // Inicia a sessão no topo da página para usar $_SESSION

// Recupera mensagens de erro ou sucesso da sessão
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';

// Limpa as mensagens da sessão após recuperá-las para que não apareçam novamente
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);

// Não é necessário incluir controllers ou models aqui,
// pois este arquivo será incluído pelo AuthController::register() no index.php
// e o controlador já terá instanciado os models e tratado a lógica. tetx
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>IronZone - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/F-RUM-ACADEMIA/Cadastro/cadastro.css">
</head>
<body>

<div class="container">
    <div class="forma">
        <img src="/F-RUM-ACADEMIA/img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="Treino na academia">
        <div class="titulo">
            <h1>IronZone</h1>
        </div>
    </div>
</div>

<div class="grade">
    <div class="cadastro-grade">
        <h2 class="titulo-cadastro">Cadastro</h2>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <form action="/F-RUM-ACADEMIA/Cadastro" method="POST">
            <p class="Dados">Nome:</p>
            <input type="text" name="nome" placeholder="Digite seu nome" required>

            <p class="Dados">Email:</p>
            <input type="email" name="email" placeholder="Digite seu email" required>

            <p class="Dados">Senha:</p>
            <div class="password-container">
                <input id="senha" type="password" name="password" placeholder="Crie uma senha" required>
                <span class="input-group-text" onclick="toggleSenha('senha', this)">
            <i class="bi bi-eye"></i>
          </span>
            </div>

            <p class="Dados">Confirmar Senha:</p>
            <div class="password-container">
                <input id="confirmarSenha" type="password" name="confirm_password" placeholder="Repita a senha" required>
                <span class="input-group-text" onclick="toggleSenha('confirmarSenha', this)">
            <i class="bi bi-eye"></i>
          </span>
            </div>

            <button type="submit" class="botao">Cadastrar</button>
        </form>

        <a class="pagina-login" href="/F-RUM-ACADEMIA/Login">Já tem uma conta? Faça login</a>
    </div>
</div>

<script src="/F-RUM-ACADEMIA/Cadastro/cadastro.js"></script>
</body>
</html>