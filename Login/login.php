<?php
// Login/login.php

session_start(); // Inicia a sessão no topo da página para usar $_SESSION

// Recupera mensagens de erro ou sucesso da sessão
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';

// Limpa as mensagens da sessão após recuperá-las
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);

// Se esta página for acessada diretamente, o index.php já a incluirá,
// então não precisamos incluir o AuthController ou database.php aqui,
// pois o roteador já terá instanciado o AuthController e ele já lidará com a requisição POST.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IronZone - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">
  <div class="forma">
    <img src="../img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="Treino na academia">
    <div class="titulo">
      <h1>IronZone</h1>
    </div>
  </div>
</div>

<div class="grade">
  <div class="login-grade">
    <h2>Login</h2>

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

    <form action="/F-RUM-ACADEMIA/Login" method="POST">
      <input type="email" name="email" placeholder="Email" required>

      <div class="senha-grade">
        <input id="senha" type="password" name="password" placeholder="Senha" required />
        <span class="texto-senha" onclick="toggleSenha('senha', this)" style="cursor: pointer;">
            <i id="iconeSenha" class="bi bi-eye"></i>
          </span>
      </div>

      <button type="submit" class="botao">Entrar</button>
    </form>

    <a class="pagina-login" href="/F-RUM-ACADEMIA/Cadastro">Não tem uma conta? Cadastre-se</a>
  </div>
</div>

<script src="login.js"></script>
</body>
</html>