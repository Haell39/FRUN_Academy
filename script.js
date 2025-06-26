// script.js (na pasta raiz)

window.addEventListener('load', () => {
    const tempoCarregamento = 2000; // 2 segundos

    setTimeout(() => {
        // Redireciona para a rota da "Tela de Início" que o index.php vai processar.
        // Assegure-se que '/F-RUM-ACADEMIA' é o nome correto da sua pasta raiz na URL.
        window.location.href = '/F-RUM-ACADEMIA/Tela-Inicio';
    }, tempoCarregamento);
});