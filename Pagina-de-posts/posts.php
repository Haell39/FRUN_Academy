<?php
// Pagina-de-posts/posts.php

session_start(); // Inicia a sessão no topo da página

// Inclui o controlador de posts
// O index.php já faz isso, mas se esta página for acessada diretamente em algum teste, é bom ter.
// No entanto, para seguir o fluxo do roteador, geralmente não se inclui controladores diretamente nas views.
// A $pdo, $postController, etc. já virão do index.php quando ele incluir esta página.

// Recupera mensagens de erro ou sucesso da sessão
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';

// Limpa as mensagens da sessão após recuperá-las
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);

// A variável $posts deve ser populada pelo PostController::index()
// Se este arquivo for incluído pelo controller, $posts já estará disponível.
// Caso contrário, para testar isoladamente (não recomendado no fluxo final):
// require_once __DIR__ . '/../src/config/database.php';
// require_once __DIR__ . '/../src/models/Post.php';
// $postModel = new Post($pdo);
// $posts = $postModel->getAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IronZone - Fórum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="posts.css" />
</head>

<body>

<div class="header">
  <h1>
    <span style="color: rgb(0, 0, 0);">Iron</span><span style="color: rgb(149, 6, 6);">Zone</span>
  </h1>

  <div class="header-right">
    <div class="novo-post-container">
      <button id="btn-novo-post">+ Novo Post</button>
    </div>
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <a href="/F-RUM-ACADEMIA/Login/logout" class="btn btn-secondary">Sair</a>
    <?php endif; ?>
  </div>
</div>

<div class="main-content">
  <div class="sidebar">
    <ul>
      <li><a href="/F-RUM-ACADEMIA/Tela-Inicio"><i class="bi bi-house-door"></i>Início</a></li>
      <li><a href="/F-RUM-ACADEMIA/Perfil"><i class="bi bi-person"></i> Perfil</a></li>
      <li><a href="/F-RUM-ACADEMIA/Login/logout"><i class="bi bi-box-arrow-right"></i>Sair</a></li>
    </ul>
  </div>

  <div class="content-area">
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

    <div id="posts-container">
      <?php
        // Verifica se a variável $posts foi definida pelo controlador e se há posts
        if (isset($posts) && !empty($posts)) {
            foreach ($posts as $post) {
                // Acessa as propriedades do objeto $post (user_id, titulo, corpo, created_at, apelido)
                // Use htmlspecialchars() para evitar XSS ao exibir conteúdo do usuário
        ?>
      <div class="post-preview-card" id="post-preview-<?php echo htmlspecialchars($post->id); ?>">
        <div class="card-header">
          <img src="../img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="" width="100">
          <div class="card-info">
            <p class="autor-nome"><strong><?php echo htmlspecialchars($post->apelido); ?></strong></p>
            <small class="post-data"><?php echo date('d/m/Y H:i', strtotime($post->created_at)); ?></small>
          </div>
        </div>
        <h3 class="titulo-post"><?php echo htmlspecialchars($post->titulo); ?></h3>
        <p class="preview-content"><?php echo htmlspecialchars(substr($post->corpo, 0, 150)); ?>...</p>

        <a href="/F-RUM-ACADEMIA/posts-abertos/show/<?php echo htmlspecialchars($post->id); ?>" class="ver-btn">Ver Post Completo</a>

        <?php
                    // Botões de Editar e Deletar (apenas se o usuário logado for o autor do post)
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id):
        ?>
        <div class="post-actions mt-2">
          <button class="btn btn-sm btn-warning edit-post-btn" data-id="<?php echo htmlspecialchars($post->id); ?>" data-titulo="<?php echo htmlspecialchars($post->titulo); ?>" data-conteudo="<?php echo htmlspecialchars($post->corpo); ?>">Editar</button>
          <a href="/F-RUM-ACADEMIA/posts-abertos/delete/<?php echo htmlspecialchars($post->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar este post?');">Deletar</a>
        </div>
        <?php endif; ?>
      </div>
      <?php
            }
        } else {
            echo "<p>Nenhum post encontrado ainda. Seja o primeiro a postar!</p>";
      }
      ?>
    </div>
  </div>

  <div class="extra-right-panel">
    <a class="sites" target="_blank" href="https://www.instagram.com/"><i class="bi bi-instagram"></i>Instagram</a>
    <a class="sites" href="https://www.facebook.com/"><i class="bi bi-facebook"></i>Facebook</a>
    <a class="sites" href="https://www.youtube.com/"><i class="bi bi-youtube"></i>Youtube</a>
  </div>
</div>

<div id="modal-novo-post" class="modal">
  <div class="modal-content">
    <span class="close-btn-modal" id="fechar-modal">×</span>
    <h2>Criar Novo Post</h2>
    <form id="formPost" action="/F-RUM-ACADEMIA/Pagina-de-posts/create" method="POST">
      <input type="text" id="titulo" name="titulo" placeholder="Título do post" required />
      <textarea id="conteudo" name="corpo" placeholder="Conteúdo do post completo" required></textarea>
      <button type="submit">Publicar</button>
    </form>
  </div>
</div>

<div id="modal-editar-post" class="modal">
  <div class="modal-content">
    <span id="fechar-modal-editar" class="fechar-modal">×</span>
    <h2>Editar Post</h2>
    <form id="formEditarPost" method="POST">
      <input type="hidden" id="edit-post-id" name="id" />
      <input type="text" id="edit-titulo" name="titulo" placeholder="Título" required />
      <textarea id="edit-conteudo" name="corpo" placeholder="Conteúdo" required></textarea>
      <button type="submit">Salvar Alterações</button>
    </form>
  </div>
</div>

<div id="modal-post-lightbox" class="modal-lightbox">
  <div class="modal-content" id="lightbox-content">
    <button id="fechar-lightbox" class="close-btn">Fechar</button>
  </div>
</div>

<script src="posts.js"></script>
</body>

</html>