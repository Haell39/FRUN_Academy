<?php
// F-RUM-ACADEMIA/index.php

session_start(); // Inicia a sessão para todo o aplicativo. Faça isso UMA VEZ no ponto de entrada.

// Inclui a configuração do banco de dados para que a variável $pdo esteja disponível
require_once __DIR__ . '/src/config/database.php';

// Inclui todos os controladores necessários
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/controllers/PostController.php';
require_once __DIR__ . '/src/controllers/PerfilController.php';

// Instancia os controladores, passando a conexão PDO
$authController = new AuthController($pdo);
$postController = new PostController($pdo);
$perfilController = new PerfilController($pdo);

// --- Lógica de Roteamento Simples ---
// Isso é um roteador MUITO básico. Em projetos maiores, usaria-se um framework (Slim, Laravel, etc.)
// Obtém o caminho da URL (ex: /F-RUM-ACADEMIA/Login/login.php -> /Login/login.php)
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove o subdiretório do projeto da URL, se estiver rodando em um subdiretório (como no XAMPP/WAMP)
// Ajuste 'F-RUM-ACADEMIA' para o nome exato da sua pasta raiz se for diferente na URL
$base_path = '/F-RUM-ACADEMIA'; // <-- ATENÇÃO: Ajuste esta linha se o nome da sua pasta raiz na URL for diferente!
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Remove a barra inicial para facilitar o match (ex: /Login/login.php -> Login/login.php)
$request_uri = ltrim($request_uri, '/');

// Quebra a URI em partes para identificar o recurso/ação
$segments = explode('/', $request_uri);

// Define a rota padrão
$controller_name = $segments[0] ?? 'Tela-Inicio'; // Se não houver nada, vai para Tela-Inicio
$action_name = $segments[1] ?? 'index'; // Ação padrão é 'index'
$id = $segments[2] ?? null; // ID para actions como 'show', 'edit', 'delete'

// Lógica de roteamento
switch ($controller_name) {
    case '': // Para a raiz do site, ex: http://localhost/F-RUM-ACADEMIA/
    case 'Tela-Inicio':
        // A página principal Tela-Inicio/tela-inicio.php
        include __DIR__ . '/Tela-Inicio/tela-inicio.php';
        break;

    case 'Login':
        // Rota para o login
        if ($action_name === 'login' || empty($action_name)) {
            $authController->login(); // Lida com GET e POST
        } elseif ($action_name === 'logout') {
            $authController->logout();
        }
        break;

    case 'Cadastro':
        // Rota para o cadastro
        if ($action_name === 'cadastro' || empty($action_name)) {
            $authController->register(); // Lida com GET e POST
        }
        break;

    case 'Pagina-de-posts':
        // Rota para a lista de posts
        if ($action_name === 'posts' || empty($action_name)) {
            $postController->index();
        } elseif ($action_name === 'create') { // Rota para criar novo post (se tiver um formulário separado)
            $postController->create();
        }
        break;

    case 'posts-abertos':
        // Rota para um post específico (e seus comentários)
        if ($action_name === 'show' && $id !== null) {
            $postController->show($id);
        } elseif ($action_name === 'edit' && $id !== null) { // Para edição de posts
            $postController->update($id); // Lida com GET para exibir form e POST para processar
        } elseif ($action_name === 'delete' && $id !== null) { // Para deletar posts
            $postController->delete($id);
        } elseif ($action_name === 'comment') { // Para adicionar comentários a um post
            $postController->createComment();
        } else {
            // Redireciona para a lista de posts se a URL de post-aberto não tiver ID válido
            header('Location: ' . $base_path . '/Pagina-de-posts/posts.php');
            exit;
        }
        break;

    case 'Perfil':
        // Rota para o perfil do usuário
        if ($action_name === 'perfil' || empty($action_name)) {
            $perfilController->show($_SESSION['user_id'] ?? null); // Mostra o perfil do logado
        } elseif ($action_name === 'show' && $id !== null) {
            $perfilController->show($id); // Mostra perfil de outro usuário por ID
        } elseif ($action_name === 'edit') { // Para editar o próprio perfil
            $perfilController->update();
        }
        break;

    // Adicione mais casos para outras seções do seu site conforme necessário
    default:
        // Página não encontrada (404) ou redirecionar para a página inicial
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1><p>A página que você está procurando não existe.</p>";
        // Ou, redirecionar para a home: header('Location: ' . $base_path . '/Tela-Inicio/tela-inicio.php');
        exit;
}
?>