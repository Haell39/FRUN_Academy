<?php
// posts-abertos/posts-abertos.php

session_start(); // Inicia a sessão no topo da página

// Recupera mensagens de erro ou sucesso da sessão
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';

// Limpa as mensagens da sessão após recuperá-las
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);

// As variáveis $post e $comentarios devem ser populadas pelo PostController::show()
// Se este arquivo for incluído pelo controller, $post e $comentarios já estarão disponíveis.
// Caso contrário, significa que o ID do post não foi encontrado ou o acesso foi direto.
if (!isset($post) || !$post) {
    // Redireciona para a página de listagem de posts se o post não for encontrado
    header('Location: /F-RUM-ACADEMIA/Pagina-de-posts');
    exit;
}

// Para exibir a data formatada
$post_date_formatted = date('d/m/Y H:i', strtotime($post->created_at));

// Verifica se o usuário logado é o autor do post para mostrar botões de edição/exclusão
$is_author = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['user_id'] == $post->user_id);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($post->titulo); ?> - IronZone</title>
    <style>
        /* CSS básico para o post aberto, similar ao preview */

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .post-container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            padding: 20px;
        }
        .post-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ddd;
        }
        .autor-nome {
            font-weight: 700;
            font-size: 1.2em;
        }
        .post-data {
            color: #666;
            font-size: 0.9em;
        }
        h1.titulo-post {
            margin: 10px 0 20px;
        }
        .post-conteudo {
            white-space: pre-wrap;
            font-size: 1em;
            line-height: 1.5;
            margin-bottom: 25px;
        }
        .actions {
            margin-bottom: 30px;
        }
        .actions button {
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        .editar-btn {
            background-color: #007bff;
            color: white;
        }
        .excluir-btn {
            background-color: #dc3545;
            color: white;
        }
        .comments-section {
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .comments-section h3 {
            margin-bottom: 15px;
        }
        .comment {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 15px;
        }
        .foto-comentario {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ccc;
        }
        .texto-comentario {
            background-color: #f4f4f4;
            padding: 10px 15px;
            border-radius: 10px;
            flex-grow: 1;
            white-space: pre-wrap;
        }
        .comment-form textarea {
            width: 100%;
            min-height: 70px;
            resize: vertical;
            padding: 10px;
            font-size: 1em;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            font-family: inherit;
        }
        .comment-form button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
        }
        /* Modal edição simples para exemplo */
        #modal-editar-post {
            display: none;
            position: fixed;
            top: 0; left: 0; right:0; bottom:0;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        #modal-editar-post .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        #modal-editar-post form input,
        #modal-editar-post form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-family: inherit;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        #modal-editar-post form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        #modal-editar-post .close-btn {
            float: right;
            cursor: pointer;
            font-weight: 700;
            font-size: 1.2em;
            margin-bottom: 10px;
            border: none;
            background: none;
        }
    </style>
</head>
<body>

<div class="post-container" id="post-container">
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

    <div class="post-header">
        <img src="../img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="avatar" class="avatar">
        <div>
            <p class="autor-nome"><strong><?php echo htmlspecialchars($post->apelido); ?></strong></p>
            <p class="post-data"><?php echo $post_date_formatted; ?></p>
        </div>
    </div>

    <h1 class="titulo-post"><?php echo htmlspecialchars($post->titulo); ?></h1>

    <div class="post-conteudo">
        <?php echo nl2br(htmlspecialchars($post->corpo)); ?>
    </div>

    <div class="actions">
        <?php if ($is_author): // Mostra os botões apenas se o usuário logado for o autor ?>
            <button class="editar-btn" id="btn-editar"
                    data-id="<?php echo htmlspecialchars($post->id); ?>"
                    data-titulo="<?php echo htmlspecialchars($post->titulo); ?>"
                    data-conteudo="<?php echo htmlspecialchars($post->corpo); ?>">Editar</button>
            <a href="/F-RUM-ACADEMIA/posts-abertos/delete/<?php echo htmlspecialchars($post->id); ?>"
               class="excluir-btn" id="btn-excluir" onclick="return confirm('Tem certeza que deseja deletar este post?');">Excluir</a>
        <?php endif; ?>
    </div>

    <div class="comments-section">
        <h3>Comentários</h3>

        <div class="comments-list">
            <?php
            if (isset($comentarios) && !empty($comentarios)) {
                foreach ($comentarios as $comentario) {
                    ?>
                    <div class="comment">
                        <img src="../img/Imagens-Blog-Lund-Trainers-768x512 (1).png" alt="foto" class="foto-comentario">
                        <div class="texto-comentario">
                            <strong><?php echo htmlspecialchars($comentario->apelido); ?></strong> (<?php echo date('d/m/Y', strtotime($comentario->created_at)); ?>)<br>
                            <?php echo nl2br(htmlspecialchars($comentario->texto)); ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>";
            }
            ?>
        </div>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): // Formulário de comentário só para logados ?>
            <form class="comment-form" action="/F-RUM-ACADEMIA/posts-abertos/comment" method="POST">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post->id); ?>">
                <textarea name="texto" placeholder="Escreva um comentário..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        <?php else: ?>
            <p>Faça <a href="/F-RUM-ACADEMIA/Login">login</a> para comentar.</p>
        <?php endif; ?>
    </div>
</div>

<div id="modal-editar-post" style="display: none;">
    <div class="modal-content">
        <button id="fechar-modal-editar" class="close-btn">&times;</button>
        <form id="formEditarPost" method="POST">
            <input type="hidden" id="edit-post-id" name="id" />
            <input type="text" id="edit-titulo" name="titulo" placeholder="Título" required />
            <textarea id="edit-conteudo" name="corpo" placeholder="Conteúdo" rows="6" required></textarea>
            <button type="submit">Salvar</button>
        </form>
    </div>
</div>

<script src="posts-abertos.js"></script>
</body>
</html>