// Tela-Inicio/tela-inicio.js

window.addEventListener('load', () => {
    const tempoCarregamento = 2000; // 2 segundos (ajuste conforme necessário)
    const loadingScreen = document.getElementById('loading-screen');
    const mainContent = document.getElementById('main-content');

    setTimeout(() => {
        // Oculta a tela de carregamento
        if (loadingScreen) {
            loadingScreen.style.display = 'none';
        }
        // Exibe o conteúdo principal da página
        if (mainContent) {
            mainContent.style.display = 'block';
        }

        // Você pode redirecionar para a página principal de posts aqui,
        // OU, se esta página já é o "início" após o carregamento,
        // apenas mostra o conteúdo e os botões de Login/Cadastro.
        // A sua index.php já redireciona para esta página.
        // Se o objetivo é que, APÓS O LOADING, vá para os posts, então:
        // window.location.href = '/F-RUM-ACADEMIA/Pagina-de-posts'; // Redireciona para os posts após o loading
        // Ou, se esta página é o destino final do loading:
        // Não adicione redirecionamento aqui se a intenção é exibir os botões de Login/Cadastro.
        // A decisão aqui depende do fluxo de UX que você deseja.

    }, tempoCarregamento);
});

// Nota: No seu tela-inicio.php, você tem
// <div id="loading-screen">...</div>
// <div id="main-content" style="display: none;">...</div>
// Este JS agora controlará a transição entre eles.