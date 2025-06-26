// Pagina-de-posts/posts.js

// Referências aos elementos do DOM
const modalNovoPost = document.getElementById('modal-novo-post');
const btnNovoPost = document.getElementById('btn-novo-post');
const btnFecharNovoPost = document.getElementById('fechar-modal');

const modalEditarPost = document.getElementById('modal-editar-post');
const btnFecharEditarPost = document.getElementById('fechar-modal-editar');
const formEditarPost = document.getElementById('formEditarPost'); // O formulário de edição
const editPostIdInput = document.getElementById('edit-post-id'); // Input hidden para o ID
const editTituloInput = document.getElementById('edit-titulo');   // Input para o título
const editConteudoTextarea = document.getElementById('edit-conteudo'); // Textarea para o conteúdo

const modalLightbox = document.getElementById('modal-post-lightbox');
const btnFecharLightbox = document.getElementById('fechar-lightbox');


// --- Funções para Abrir/Fechar Modais ---

// Abrir modal Novo Post
if (btnNovoPost) { // Verifica se o botão existe antes de adicionar o listener
 btnNovoPost.addEventListener('click', () => {
  modalNovoPost.style.display = 'block';
 });
}

// Fechar modal Novo Post
if (btnFecharNovoPost) {
 btnFecharNovoPost.addEventListener('click', () => {
  modalNovoPost.style.display = 'none';
 });
}

// Fechar modal Editar Post
if (btnFecharEditarPost) {
 btnFecharEditarPost.addEventListener('click', () => {
  modalEditarPost.style.display = 'none';
 });
}

// Fechar modal Lightbox
if (btnFecharLightbox) {
 btnFecharLightbox.addEventListener('click', () => {
  modalLightbox.style.display = 'none';
 });
}

// Fechar modais ao clicar fora (no overlay)
window.addEventListener('click', (e) => {
 if (e.target === modalNovoPost) modalNovoPost.style.display = 'none';
 if (e.target === modalEditarPost) modalEditarPost.style.display = 'none';
 if (e.target === modalLightbox) modalLightbox.style.display = 'none';
});

// --- Lógica para o Modal de Edição (para pré-popular o formulário) ---

// Adiciona event listeners aos botões "Editar" que serão gerados pelo PHP
document.addEventListener('click', (e) => {
 if (e.target.classList.contains('edit-post-btn')) {
  const postId = e.target.dataset.id;
  const postTitulo = e.target.dataset.titulo;
  const postConteudo = e.target.dataset.conteudo;

  // Preenche o formulário de edição com os dados do post
  editPostIdInput.value = postId;
  editTituloInput.value = postTitulo;
  editConteudoTextarea.value = postConteudo;

  // Define o 'action' do formulário dinamicamente com o ID do post
  // Isso fará com que o formulário submeta para a rota correta do controlador
  // Ex: /F-RUM-ACADEMIA/posts-abertos/edit/123
  formEditarPost.action = `/F-RUM-ACADEMIA/posts-abertos/edit/${postId}`;

  // Exibe o modal de edição
  modalEditarPost.style.display = 'block';
 }
});

// --- Lógica para o Modal Lightbox (abrir e possivelmente carregar conteúdo via AJAX) ---

// Adiciona event listeners aos botões "Ver Post Completo"
document.addEventListener('click', (e) => {
 if (e.target.classList.contains('ver-btn')) {
  e.preventDefault(); // Impede o link de redirecionar imediatamente
  const postId = e.target.href.split('/').pop(); // Pega o ID do post da URL do link

  // **Comentado: Lógica antiga de localStorage removida**
  // localStorage.setItem('postAberto', JSON.stringify(posts[index]));
  // window.location.href = '../posts-abertos/posts-abertos.php';

  // **Nova abordagem:** Redireciona para a página do post aberto, onde o PHP vai carregar tudo.
  // O JS não vai mais preencher o lightbox na mesma página aqui.
  // Em vez disso, o link já aponta para a rota PHP que lida com isso.
  window.location.href = `/F-RUM-ACADEMIA/posts-abertos/show/${postId}`;

  // Se você QUISER manter a funcionalidade de lightbox na mesma página,
  // VOCÊ PRECISARIA FAZER UMA REQUISIÇÃO AJAX AQUI para pegar os detalhes do post
  // e depois injetá-los no 'lightboxContent'.
  // Isso é mais complexo e pode ser feito depois. Por enquanto, a abordagem é redirecionar.
  /*
  // Exemplo de como faria com AJAX (apenas para referência, não implementado totalmente)
  fetch(`/F-RUM-ACADEMIA/api/post/${postId}`) // Uma API que retorna JSON do post e comentários
      .then(response => response.json())
      .then(data => {
          // Preencher lightboxContent com os dados (data.post, data.comentarios)
          // modalLightbox.style.display = 'flex';
      })
      .catch(error => console.error('Erro ao carregar post:', error));
  */
 }
});


// As funções de salvamento/carregamento de posts no localStorage e
// a renderização completa da lista de posts pelo JS foram removidas,
// pois agora o PHP é responsável por isso.

// As funções de comentário no JS também seriam simplificadas,
// submetendo o formulário de comentário para uma rota PHP.
// A exibição dos comentários seria feita pelo PHP na página do post.

// Limpeza e inicialização podem ser feitas pelo PHP ou mantendo as partes relevantes aqui.
// As partes comentadas do seu código original podem ser removidas.