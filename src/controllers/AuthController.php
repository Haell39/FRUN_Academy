<?php
// src/controllers/AuthController.php

// Inclui o arquivo de configuração do banco de dados para ter a conexão PDO ($pdo)
require_once __DIR__ . '/../config/database.php';
// Inclui o modelo de usuário
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    // Lida com o cadastro de novos usuários
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apelido = trim($_POST['apelido'] ?? '');
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $regiao = trim($_POST['regiao'] ?? null);

            // Validações básicas (você pode adicionar mais, ex: tamanho min/max)
            if (empty($apelido) || empty($email) || empty($password) || empty($confirm_password)) {
                // Flash message ou erro na sessão
                $_SESSION['error_message'] = "Todos os campos obrigatórios devem ser preenchidos.";
                header('Location: /F-RUM-ACADEMIA/Cadastro/cadastro.php'); // Redireciona de volta ao formulário
                exit;
            }

            if ($password !== $confirm_password) {
                $_SESSION['error_message'] = "As senhas não coincidem.";
                header('Location: /F-RUM-ACADEMIA/Cadastro/cadastro.php');
                exit;
            }

            // Verifica se o email ou apelido já existem
            if ($this->userModel->findByEmail($email)) {
                $_SESSION['error_message'] = "Este e-mail já está cadastrado.";
                header('Location: /F-RUM-ACADEMIA/Cadastro/cadastro.php');
                exit;
            }
            // Você pode adicionar uma verificação para apelido também

            if ($this->userModel->create($apelido, $nome, $email, $password, 'default_profile.png', $regiao)) {
                $_SESSION['success_message'] = "Cadastro realizado com sucesso! Faça login.";
                header('Location: /F-RUM-ACADEMIA/Login/login.php'); // Redireciona para a página de login
                exit;
            } else {
                $_SESSION['error_message'] = "Erro ao cadastrar usuário. Tente novamente.";
                header('Location: /F-RUM-ACADEMIA/Cadastro/cadastro.php');
                exit;
            }
        } else {
            // Se não for POST, apenas exibe a página de cadastro
            include __DIR__ . '/../../Cadastro/cadastro.php'; // Inclui a view de cadastro
        }
    }

    // Lida com o login de usuários
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error_message'] = "Por favor, preencha e-mail e senha.";
                header('Location: /F-RUM-ACADEMIA/Login/login.php');
                exit;
            }

            $user = $this->userModel->verifyPassword($email, $password);

            if ($user) {
                // Inicia a sessão e armazena os dados do usuário
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_apelido'] = $user->apelido;
                $_SESSION['logged_in'] = true;

                $_SESSION['success_message'] = "Login realizado com sucesso!";
                header('Location: /F-RUM-ACADEMIA/Pagina-de-posts/posts.php'); // Redireciona para a página de posts
                exit;
            } else {
                $_SESSION['error_message'] = "E-mail ou senha incorretos.";
                header('Location: /F-RUM-ACADEMIA/Login/login.php');
                exit;
            }
        } else {
            // Se não for POST, apenas exibe a página de login
            include __DIR__ . '/../../Login/login.php'; // Inclui a view de login
        }
    }

    // Lida com o logout
    public function logout() {
        session_start(); // Inicia a sessão
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destrói a sessão
        header('Location: /F-RUM-ACADEMIA/Login/login.php'); // Redireciona para a página de login
        exit;
    }
}