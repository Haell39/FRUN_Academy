// posts-abertos/posts-abertos.js

// Referências aos elementos do DOM
const modalEditar = document.getElementById('modal-editar-post');
const formEditar = document.getElementById('formEditarPost');
const btnFecharEditar = document.getElementById('fechar-modal-editar');

// Inputs do formulário de edição (adicionados no HTML PHP)
const editPostIdInput = document.getElementById('edit-post-id');
const editTituloInput = document.getElementById('edit-titulo');
const editConteudoTextarea = document.getElementById('edit-conteudo');

// Botões de Ação do Post (Edit e Delete)
const btnEditarPost = document.getElementById('btn-editar'); // O botão "Editar" no post
const btnExcluirPost = document.getElementById('btn-excluir'); // O botão "Excluir" no post


// --- Funções para Abrir/Fechar Modal de Edição ---

function abrirModalEditar() {
  // Pega os dados do botão "Editar" via data-attributes, que foram preenchidos pelo PHP
  const postId = btnEditarPost.dataset.id;
  const postTitulo = btnEditarPost.dataset.titulo;
  const postConteudo = btnEditarPost.dataset.conteudo;

  // Preenche os campos do formulário de edição com esses dados
  editPostIdInput.value = postId;
  editTituloInput.value = postTitulo;
  editConteudoTextarea.value = postConteudo;

  // Define o 'action' do formulário dinamicamente com o ID do post
  // Isso fará com que o formulário submeta para a rota correta do controlador
  formEditar.action = `/F-RUM-ACADEMIA/posts-abertos/edit/${postId}`;

  modalEditar.style.display = 'flex'; // Exibe o modal
}

// Fechar modal de edição
if (btnFecharEditar) {
  btnFecharEditar.addEventListener('click', () => {
    modalEditar.style.display = 'none';
  });
}

// Fechar modal ao clicar fora (no overlay)
window.addEventListener('click', (e) => {
  if (e.target === modalEditar) {
    modalEditar.style.display = 'none';
  }
});


// --- Event Listeners para Ações do Post ---

// Botão "Editar" do Post (abre o modal de edição)
// Este listener só é adicionado se o botão existe (ou seja, se o usuário é o autor do post)
if (btnEditarPost) {
  btnEditarPost.addEventListener('click', abrirModalEditar);
}

// Botão "Excluir" do Post (já tem a confirmação inline no HTML, mas podemos adicionar JS se preferir AJAX)
// No momento, o link já faz a confirmação e redireciona para a rota DELETE do PHP.
// Não precisa de JS adicional aqui a menos que queira uma deleção AJAX.
// if (btnExcluirPost) {
//     btnExcluirPost.addEventListener('click', (e) => {
//         // Se você quisesse fazer via AJAX, você impediria o default e faria um fetch()
//         // e.preventDefault();
//         // if (confirm('Deseja realmente excluir este post?')) {
//         //    fetch(`/F-RUM-ACADEMIA/posts-abertos/delete/${e.target.dataset.id}`, { method: 'POST' }) // ou DELETE
//         //        .then(response => response.json())
//         //        .then(data => { /* lidar com a resposta */ })
//         //        .catch(error => console.error('Erro:', error));
//         // }
//     });
// }


// --- Submissão do Formulário de Edição (agora para PHP) ---
// O formulário já tem um 'action' dinâmico definido em abrirModalEditar() e 'method="POST"'.
// O JavaScript não precisa interceptar o submit para salvar no localStorage.
// O PHP no PostController::update() vai processar os dados.

// --- Submissão do Formulário de Comentário (agora para PHP) ---
// O formulário de comentário no HTML já tem 'action="/F-RUM-ACADEMIA/posts-abertos/comment"' e 'method="POST"'.
// O JavaScript não precisa mais manipular os comentários no frontend ou localStorage.
// O PHP no PostController::createComment() vai processar e salvar.

// --- Funções e Variáveis de localStorage Removidas ---
// formatarData, postContainer, post, carregarPostAberto, renderizarPost,
// usuarioLogado, podeEditar, renderizarComentarios, enviarComentario,
// salvarPostAberto, atualizarPostsGeral, excluirPost.
// Todas essas lógicas são agora responsabilidade do backend PHP.