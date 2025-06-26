<?php
// F-RUM-ACADEMIA/Tela-Inicio/tela-inicio.php

// AVISO: session_start() foi removido daqui porque já é chamado no index.php
// Esta página é a que é incluída pelo index.php (o roteador) quando a rota 'Tela-Inicio' é acessada.
// Não há necessidade de includes de controllers ou models aqui, a menos que esta página precise exibir dados dinâmicos.

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IronZone - Início</title>
    <link rel="stylesheet" href="/F-RUM-ACADEMIA/Tela-Inicio/tela-inicio.css">
</head>
<body>
<div class="container">
    <div class="forma">
        <img src="/F-RUM-ACADEMIA/img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="Treino na academia">
        <div class="titulo">
            <h1>IronZone</h1>
            <p>Compartilhe treinos e tire dúvidas</p>
        </div>
    </div>
</div>
<div class="lol">
    <h1>Bem-vindo à IronZone</h1>
    <p>Aqui você encontra dicas, apoio e muita motivação para crescer junto!</p>
    <div class="botoes">
        <a href="/F-RUM-ACADEMIA/Login" class="btn">Login</a>
        <a href="/F-RUM-ACADEMIA/Cadastro" class="btn">Cadastrar</a>
        <a href="/F-RUM-ACADEMIA/Pagina-de-posts" class="btn">Ver Posts</a>
    </div>
</div>
<script src="/F-RUM-ACADEMIA/Tela-Inicio/tela-inicio.js"></script>
</body>
</html>