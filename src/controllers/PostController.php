<?php
// src/controllers/PostController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Comentario.php'; // Inclui o modelo de Comentário

class PostController {
    private $postModel;
    private $comentarioModel; // Instância do modelo de Comentário

    public function __construct($pdo) {
        $this->postModel = new Post($pdo);
        $this->comentarioModel = new Comentario($pdo);
    }

    // Lista todos os posts
    public function index() {
        $posts = $this->postModel->getAll();
        // Os posts serão passados para a view Pagina-de-posts/posts.php
        include __DIR__ . '/../../Pagina-de-posts/posts.php';
    }

    // Exibe um post específico e seus comentários
    public function show($id) {
        $post = $this->postModel->findById($id);
        $comentarios = $this->comentarioModel->getByPostId($id); // Obtém comentários do post

        if (!$post) {
            // Post não encontrado, redirecionar ou mostrar erro
            header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php'); // Ou uma página 404
            exit;
        }
        // O post e os comentários serão passados para a view posts-abertos/posts-abertos.php
        include __DIR__ . '/../../posts-abertos/posts-abertos.php';
    }

    // Lida com a criação de posts
    public function create() {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['error_message'] = "Você precisa estar logado para criar um post.";
            header('Location: /F-RUM-ACADEMIA/Login/login.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $corpo = trim($_POST['corpo'] ?? '');
            $user_id = $_SESSION['user_id'];

            if (empty($titulo) || empty($corpo)) {
                $_SESSION['error_message'] = "Título e corpo do post são obrigatórios.";
                // Poderia redirecionar para um formulário de criação de post
                header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php'); // Temporário, ou uma página de "novo-post.php"
                exit;
            }

            if ($this->postModel->create($user_id, $titulo, $corpo)) {
                $_SESSION['success_message'] = "Post criado com sucesso!";
                header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
                exit;
            } else {
                $_SESSION['error_message'] = "Erro ao criar post. Tente novamente.";
                header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
                exit;
            }
        }
        // Se for GET, exibir o formulário de criação de post
        // (Você precisará de uma página HTML/PHP para o formulário de "novo post")
        // include __DIR__ . '/../../Pagina-de-posts/novo_post.php'; // Exemplo
    }

    // Lida com a atualização de posts
    public function update($id) {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['error_message'] = "Você precisa estar logado para editar um post.";
            header('Location: /F-RUM-ACADEMIA/Login/login.php');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post || $post->user_id !== $_SESSION['user_id']) {
            $_SESSION['error_message'] = "Você não tem permissão para editar este post.";
            header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $corpo = trim($_POST['corpo'] ?? '');

            if (empty($titulo) || empty($corpo)) {
                $_SESSION['error_message'] = "Título e corpo do post são obrigatórios.";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $id); // Redireciona para a página do post
                exit;
            }

            if ($this->postModel->update($id, $titulo, $corpo)) {
                $_SESSION['success_message'] = "Post atualizado com sucesso!";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $id);
                exit;
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar post. Tente novamente.";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $id);
                exit;
            }
        } else {
            // Exibir formulário de edição (com dados pré-preenchidos)
            // (Você precisará de uma página HTML/PHP para o formulário de "editar post")
            // include __DIR__ . '/../../Pagina-de-posts/editar_post.php'; // Exemplo
        }
    }

    // Lida com a exclusão de posts
    public function delete($id) {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['error_message'] = "Você precisa estar logado para deletar um post.";
            header('Location: /F-RUM-ACADEMIA/Login/login.php');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post || $post->user_id !== $_SESSION['user_id']) {
            $_SESSION['error_message'] = "Você não tem permissão para deletar este post.";
            header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
            exit;
        }

        if ($this->postModel->delete($id)) {
            $_SESSION['success_message'] = "Post deletado com sucesso!";
            header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Erro ao deletar post. Tente novamente.";
            header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $id);
            exit;
        }
    }

    // Lida com a criação de comentários
    public function createComment() {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['error_message'] = "Você precisa estar logado para comentar.";
            // Redireciona para a página do post anterior se possível, ou login
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/F-RUM-ACADEMIA/Login/login.php'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = $_POST['post_id'] ?? null;
            $texto = trim($_POST['texto'] ?? '');
            $user_id = $_SESSION['user_id'];

            if (empty($post_id) || empty($texto)) {
                $_SESSION['error_message'] = "Comentário não pode ser vazio.";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $post_id);
                exit;
            }

            if ($this->comentarioModel->create($user_id, $post_id, $texto)) {
                $_SESSION['success_message'] = "Comentário adicionado com sucesso!";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $post_id);
                exit;
            } else {
                $_SESSION['error_message'] = "Erro ao adicionar comentário. Tente novamente.";
                header('Location: /F-RUM-ACADEMIA/posts-abertos/posts-abertos.php?id=' . $post_id);
                exit;
            }
        }
        // Se for GET, algo está errado, redirecionar
        header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
        exit;
    }
}
?>