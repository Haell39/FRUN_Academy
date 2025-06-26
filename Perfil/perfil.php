<?php
// Perfil/perfil.php

session_start(); // Inicia a sessão no topo da página

// Recupera mensagens de erro ou sucesso da sessão
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';

// Limpa as mensagens da sessão após recuperá-las
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);

// A variável $user (e $user_posts) deve ser populada pelo PerfilController::show() ou update()
// Se este arquivo for incluído pelo controller, $user já estará disponível.
// No entanto, para fins de teste e clareza, vamos garantir que ele exista aqui,
// assumindo que o PerfilController já o processou.
// Se o PerfilController não passou $user, significa que algo deu errado ou o usuário não está logado.
if (!isset($user) || !$user) {
    // Redirecionar para login ou página de erro se o usuário não estiver logado ou perfil não encontrado
    // No fluxo do PerfilController, ele já faria esse redirecionamento.
    // Este bloco é mais um "fallback" se a página for acessada de forma inesperada.
    header('Location: /F-RUM-ACADEMIA/Login');
    exit;
}

// Para campos que podem ser nulos ou vazios no banco, defina defaults
$nome_display = htmlspecialchars($user->nome ?? '');
$apelido_display = htmlspecialchars($user->apelido ?? '');
$email_display = htmlspecialchars($user->email ?? '');
$regiao_display = htmlspecialchars($user->regiao ?? ''); // 'País' no seu HTML
$foto_display = htmlspecialchars($user->foto ?? '../img/Imagens-Blog-Lund-Trainers-768x512 (1).png'); // Default se não tiver foto
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - IronZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="perfil.css">
</head>
<body>

<div class="headere">
    <h1><span style="color: black;">Iron</span><span style="color: rgb(149, 6, 6);">Zone</span></h1>
</div>
<div class="main-content">
    <div class="sidebar">
        <ul>
            <li><a href="/F-RUM-ACADEMIA/Tela-Inicio"><i class="bi bi-house-door"></i> Início</a></li>
            <li><a href="/F-RUM-ACADEMIA/Pagina-de-posts"><i class="bi bi-chat-left-text"></i> Posts</a></li>
            <li><a href="/F-RUM-ACADEMIA/Login/logout"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
        </ul>
    </div>

    <div class="container">
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form id="profileForm" action="/F-RUM-ACADEMIA/Perfil/edit" method="POST" enctype="multipart/form-data">
            <div class="header">
                <h2>Perfil</h2>
                <button type="button" class="edit-button">
                    <i class="bi bi-pen"></i> Editar
                </button>
                <button type="submit" class="save-button" style="display:none;">
                    <i class="bi bi-check-lg"></i> Salvar
                </button>
            </div>

            <div class="profile" style="position: relative; display: inline-block;">
                <label for="fotoUpload" id="labelFoto" style="cursor: default;">
                    <img id="fotoPerfil" src="<?php echo $foto_display; ?>" alt="Profile" style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
                </label>
                <input type="file" id="fotoUpload" name="foto" accept="image/*" style="display: none;" disabled>
                <div class="profile-info">
                    <strong id="apelidoPerfil"><?php echo $apelido_display; ?></strong>
                    <span><?php echo $email_display; ?></span>
                </div>
            </div>

            <div class="form">
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" placeholder="Coloque seu nome" value="<?php echo $nome_display; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Apelido</label>
                    <input type="text" name="apelido_display_only" placeholder="Seu apelido" value="<?php echo $apelido_display; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Região (País)</label>
                    <input type="text" name="regiao" placeholder="Sua região/país" value="<?php echo $regiao_display; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Língua</label>
                    <select name="idioma" disabled>
                        <option <?php echo (isset($user->idioma) && $user->idioma == 'Selecione') ? 'selected' : ''; ?>>Selecione</option>
                        <option <?php echo (isset($user->idioma) && $user->idioma == 'Inglês') ? 'selected' : ''; ?>>Inglês</option>
                        <option <?php echo (isset($user->idioma) && $user->idioma == 'Português') ? 'selected' : ''; ?>>Português</option>
                        <option <?php echo (isset($user->idioma) && $user->idioma == 'Espanhol') ? 'selected' : ''; ?>>Espanhol</option>
                    </select>
                </div>
            </div>

            <div class="email-section">
                <h3>Meu Email de Acesso</h3>
                <div class="email-item">
                    <img id="fotoEmail" src="<?php echo $foto_display; ?>" alt="email icon" />
                    <div>
                        <div><?php echo $email_display; ?></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="content-area">
        <h3>Meus Posts</h3>
        <?php if (isset($user_posts) && !empty($user_posts)): ?>
            <?php foreach ($user_posts as $post): ?>
                <div class="my-post-card">
                    <h4><?php echo htmlspecialchars($post->titulo); ?></h4>
                    <p><?php echo htmlspecialchars(substr($post->corpo, 0, 100)); ?>...</p>
                    <small>Publicado em: <?php echo date('d/m/Y', strtotime($post->created_at)); ?></small>
                    <br>
                    <a href="/F-RUM-ACADEMIA/posts-abertos/show/<?php echo htmlspecialchars($post->id); ?>" class="btn btn-sm btn-info">Ver</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum post seu encontrado.</p>
        <?php endif; ?>
    </div>
</div>

<script src="perfil.js"></script>
</body>
</html>