// // Função para formatar data
// function formatarData(timestamp) {
//     const data = new Date(timestamp);
//     return data.toLocaleDateString('pt-BR', {
//       day: '2-digit',
//       month: '2-digit',
//       year: 'numeric'
//     });
//   }
  
//   const postContainer = document.getElementById('post-container');
   const modalEditar = document.getElementById('modal-editar-post');
   const formEditar = document.getElementById('formEditarPost');
   const btnFecharEditar = document.getElementById('fechar-modal-editar');
  
//   let post = null;
  
//   // Carrega post do localStorage
//   function carregarPostAberto() {
//     const postJSON = localStorage.getItem('postAberto');
//     if (!postJSON) {
//       postContainer.innerHTML = '<p>Nenhum post selecionado.</p>';
//       return null;
//     }
//     return JSON.parse(postJSON);
//   }
  
//   // Renderiza o post completo na página
//   function renderizarPost() {
//     if (!post) return;
  
     const usuarioLogado = JSON.parse(localStorage.getItem('usuarioLogado'));
    const podeEditar = usuarioLogado && (usuarioLogado.nome === post.autor || usuarioLogado.apelido === post.autor);
  
//     // Avatar do autor, se for o usuário logado
//     let imgSrc = '';
//     if (usuarioLogado && (usuarioLogado.nome === post.autor || usuarioLogado.apelido === post.autor)) {
//       imgSrc = usuarioLogado.foto || '';
//     }
  
//     // Monta o HTML
//     postContainer.innerHTML = `
//       <div class="post-header">
//         ${imgSrc ? `<img src="${imgSrc}" alt="avatar" class="avatar">` : `<i class="bi bi-person-fill avatar"></i>`}
//         <div>
//           <p class="autor-nome">${post.autor}</p>
//           <p class="post-data">${formatarData(post.data)}</p>
//         </div>
//       </div>
//       <h1 class="titulo-post">${post.titulo}</h1>
//       <div class="post-conteudo">${post.conteudo.replace(/\n/g, '<br>')}</div>
//       <div class="actions">
//         ${podeEditar ? `
//           <button class="editar-btn" id="btn-editar">Editar</button>
//           <button class="excluir-btn" id="btn-excluir">Excluir</button>
//         ` : ''}
//       </div>
//       <div class="comments-section">
//         <h3>Comentários</h3>
//         <div class="comments-list"></div>
//         <form class="comment-form">
//           <textarea placeholder="Escreva um comentário..." required></textarea>
//           <button type="submit">Enviar</button>
//         </form>
//       </div>
//     `;
  
//     // Renderizar comentários
//     renderizarComentarios();
  
//     // Adicionar event listeners de edição, exclusão, e envio de comentário
    if (podeEditar) {
      document.getElementById('btn-editar').addEventListener('click', abrirModalEditar);
      document.getElementById('btn-excluir').addEventListener('click', excluirPost);
    }
  
//     const commentForm = postContainer.querySelector('.comment-form');
//     commentForm.addEventListener('submit', enviarComentario);
//   }
  
//   function renderizarComentarios() {
//     const commentsList = postContainer.querySelector('.comments-list');
//     commentsList.innerHTML = '';
//     const comentarios = post.comentarios || [];
//     const comentariosAutor = post.comentariosAutor || [];
//     const comentariosFoto = post.comentariosFoto || [];
  
//     comentarios.forEach((comentario, i) => {
//       let fotoHtml = '';
//       if (comentariosFoto[i]) {
//         fotoHtml = `<img src="${comentariosFoto[i]}" alt="foto" class="foto-comentario">`;
//       }
//       commentsList.innerHTML += `
//         <div class="comment">
//           ${fotoHtml}
//           <div class="texto-comentario">${comentario.replace(/\n/g, '<br>')}</div>
//         </div>
//       `;
//     });
//   }
  
//   // Enviar novo comentário
//   function enviarComentario(e) {
//     e.preventDefault();
//     const textarea = e.target.querySelector('textarea');
//     const texto = textarea.value.trim();
//     if (!texto) return alert('Comentário vazio não é permitido.');
  
//     const usuarioLogado = JSON.parse(localStorage.getItem('usuarioLogado'));
//     if (!usuarioLogado) return alert('Você precisa estar logado para comentar.');
  
//     if (!post.comentarios) post.comentarios = [];
//     if (!post.comentariosAutor) post.comentariosAutor = [];
//     if (!post.comentariosFoto) post.comentariosFoto = [];
  
//     post.comentarios.push(texto);
//     post.comentariosAutor.push(usuarioLogado.apelido);
//     post.comentariosFoto.push(usuarioLogado.foto);
  
//     salvarPostAberto();
//     renderizarComentarios();
//     textarea.value = '';
  
//     // Atualiza os posts no localStorage geral também para manter sincronizado
//     atualizarPostsGeral();
//   }
  
//   // Salvar o post aberto no localStorage
//   function salvarPostAberto() {
//     localStorage.setItem('postAberto', JSON.stringify(post));
//   }
  
//   // Atualizar array geral de posts, para sincronizar mudanças
//   function atualizarPostsGeral() {
//     let posts = JSON.parse(localStorage.getItem('posts')) || [];
//     const index = posts.findIndex(p => p.data === post.data && p.autor === post.autor && p.titulo === post.titulo);
//     if (index >= 0) {
//       posts[index] = post;
//       localStorage.setItem('posts', JSON.stringify(posts));
//     }
//   }
  
//   // Abrir modal de edição
  function abrirModalEditar() {
    formEditar.titulo.value = post.titulo;
    formEditar.conteudo.value = post.conteudo;
    modalEditar.style.display = 'flex';
  }
  
//   // Fechar modal edição
  btnFecharEditar.addEventListener('click', () => {
    modalEditar.style.display = 'none';
  });
  
  // Salvar edição
  formEditar.addEventListener('submit', e => {
    e.preventDefault();
    const novoTitulo = formEditar.titulo.value.trim();
    const novoConteudo = formEditar.conteudo.value.trim();
    if (!novoTitulo || !novoConteudo) {
      alert('Preencha todos os campos!');
      return;
    }
    post.titulo = novoTitulo;
    post.conteudo = novoConteudo;
    post.data = Date.now();
    salvarPostAberto();
    atualizarPostsGeral();
    renderizarPost();
    modalEditar.style.display = 'none';
  });
  
//   // Excluir post
//   function excluirPost() {
//     if (!confirm('Deseja realmente excluir este post?')) return;
  
//     let posts = JSON.parse(localStorage.getItem('posts')) || [];
//     posts = posts.filter(p => !(p.data === post.data && p.autor === post.autor && p.titulo === post.titulo));
//     localStorage.setItem('posts', JSON.stringify(posts));
//     localStorage.removeItem('postAberto');
//     alert('Post excluído com sucesso.');
//     // Redireciona para página principal
//     window.location.href = '../index.html';
//   }
  
//   // Inicialização
//   post = carregarPostAberto();
//   renderizarPost();
  