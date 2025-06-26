<?php
// src/controllers/PerfilController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php'; // Para mostrar posts do usuário

class PerfilController {
    private $userModel;
    private $postModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->postModel = new Post($pdo);
    }

    // Exibe o perfil do usuário logado ou de um usuário específico
    public function show($id = null) {
        session_start();

        // Se nenhum ID for passado, tenta exibir o perfil do usuário logado
        if ($id === null) {
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
                $_SESSION['error_message'] = "Você precisa estar logado para ver seu perfil.";
                header('Location: /F-RUM-ACADEMIA/Login/login.php');
                exit;
            }
            $id = $_SESSION['user_id'];
        }

        $user = $this->userModel->findById($id);
        $user_posts = []; // Inicializa array de posts

        if ($user) {
            // Obter posts criados por este usuário (se houver um método no Post Model para isso)
            // No Post Model, você precisaria de um método tipo getByUserId($user_id)
            $query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
            $stmt = $this->userModel->getPDO()->prepare($query); // Acesso direto ao PDO do UserModel para esta consulta específica
            $stmt->bindParam(':user_id', $id);
            $stmt->execute();
            $user_posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        } else {
            $_SESSION['error_message'] = "Perfil não encontrado.";
            header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php'); // Ou alguma página de erro
            exit;
        }

        // Os dados do perfil e posts serão passados para a view Perfil/perfil.php
        include __DIR__ . '/../../Perfil/perfil.php';
    }

    // Lida com a atualização do perfil do usuário
    public function update() {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['error_message'] = "Você precisa estar logado para editar seu perfil.";
            header('Location: /F-RUM-ACADEMIA/Login/login.php');
            exit;
        }

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $regiao = trim($_POST['regiao'] ?? null);
            // $foto = ... Lógica para upload de foto, se for o caso

            if ($this->userModel->update($user_id, $nome, $email, null, $regiao)) { // Passando null para foto por enquanto
                $_SESSION['success_message'] = "Perfil atualizado com sucesso!";
                // Atualiza a sessão se o email ou apelido mudar (opcional)
                // $_SESSION['user_apelido'] = $novo_apelido;
                header('Location: /F-RUM-ACADEMIA/Perfil/perfil.php');
                exit;
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar perfil. Tente novamente.";
                header('Location: /F-RUM-ACADEMIA/Perfil/perfil.php');
                exit;
            }
        } else {
            // Exibir o formulário de edição do perfil com os dados atuais
            $user = $this->userModel->findById($user_id);
            if (!$user) {
                $_SESSION['error_message'] = "Dados do perfil não encontrados para edição.";
                header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php');
                exit;
            }
            include __DIR__ . '/../../Perfil/perfil.php'; // Reutiliza a mesma view para mostrar e editar
        }
    }
}
?>