// const postsContainer = document.getElementById('posts-container');
 const modal = document.getElementById('modal-novo-post');
 const btnNovoPost = document.getElementById('btn-novo-post');
 const btnFecharModal = document.getElementById('fechar-modal');
// const formPost = document.getElementById('formPost');

// // Modal de edição
 const modalEditar = document.getElementById('modal-editar-post');
// const formEditar = document.getElementById('formEditarPost');
 const btnFecharEditar = document.getElementById('fechar-modal-editar');
// let indiceEdicao = null;

// // Modal Lightbox
// const modalLightbox = document.getElementById('modal-post-lightbox');
// const lightboxContent = document.getElementById('lightbox-content');

// let posts = [];

// Abrir modal novo post
btnNovoPost.addEventListener('click', () => {
  modal.style.display = 'block';
});

// // Fechar modais
 btnFecharModal.addEventListener('click', () => modal.style.display = 'none');
btnFecharEditar.addEventListener('click', () => modalEditar.style.display = 'none');

// window.addEventListener('click', (e) => {
//   if (e.target === modal) modal.style.display = 'none';
//   if (e.target === modalEditar) modalEditar.style.display = 'none';
//   if (e.target === modalLightbox) modalLightbox.style.display = 'none';
// });

// // Formatar data
// function formatarData(timestamp) {
//   const data = new Date(timestamp);
//   return data.toLocaleDateString('pt-BR', {
//     day: '2-digit',
//     month: '2-digit',
//     year: 'numeric'
//   });
// }

// // Criar preview do post
// function criarPostPreview(titulo, autor, dataTimestamp, index) {
//   const preview = document.createElement('div');
//   preview.classList.add('post-preview-card');
//   preview.id = `post-preview-${index}`;

//   const usuario = JSON.parse(localStorage.getItem('usuarioLogado'));
//   let imgSrc = '';

//   // Só mostra foto se o autor for o usuário logado
//   // if (usuario && (usuario.nome === autor || usuario.apelido === autor)) {
//   //   imgSrc = usuario.foto || '';
//   // }
  
//   preview.innerHTML = `
//     <div class="card-header">
//       ${imgSrc ? `<img src="${imgSrc}" alt="avatar" class="avatar">` : `<i class="bi bi-person-fill avatar"></i>`}
//       <div class="card-info">
//         <p class="autor-nome"><strong>${autor}</strong></p>
//       </div>
//     </div>
  
//     <h3 class="titulo-post">${titulo}</h3>
//     <button class="ver-btn">Ver Post Completo</button>
//   `;

//   preview.querySelector('.ver-btn').addEventListener('click', () => {
//     localStorage.setItem('postAberto', JSON.stringify(posts[index]));
//     window.location.href = '../posts-abertos/posts-abertos.html';

//   });
  
  

//   return preview;
// }

// // Abrir post no lightbox
// function abrirPostEmLightbox(index) {
//   const post = posts[index];
//   const data = formatarData(post.data);
//   //const usuarioLogado = JSON.parse(localStorage.getItem('usuarioLogado'));
//   //const podeEditar = usuarioLogado && (usuarioLogado.nome === post.autor || usuarioLogado.apelido === post.autor);

//   lightboxContent.innerHTML = `
//     <button id="fechar-lightbox" class="close-btn">Fechar</button>
//     <h2>${post.titulo}</h2>
//     <p class="meta"><strong>${post.autor}</strong> | ${data}</p>
//     <div class="post-content"><p>${post.conteudo}</p></div>
//     <div class="actions">
//       ${podeEditar ? `
//         <button class="editar-btn">Editar</button>
//         <button class="excluir-btn delete-btn">Excluir</button>
//       ` : ''}
//     </div>
//     <div class="comments-section">
//       <h3>Comentários</h3>
//       <div class="comments-list"></div>
//       <form class="comment-form">
//         <textarea placeholder="Escreva um comentário..." required></textarea>
//         <button type="submit">Enviar</button>
//       </form>
//     </div>
//   `;

//   const commentsList = lightboxContent.querySelector('.comments-list');
//   const commentForm = lightboxContent.querySelector('.comment-form');

//   function renderizarComentarios() {
//     commentsList.innerHTML = '';
//     const comentarios = post.comentarios || [];
//     comentarios.forEach((comentario, i) => {
//       const div = document.createElement('div');
//       div.classList.add('comment');
//       let imgSrc = '';

//       // if (post.comentariosAutor && post.comentariosAutor[i] === usuarioLogado?.apelido) {
//       //   imgSrc = usuarioLogado?.foto || '';
//       // }

//       div.innerHTML = `
//         ${imgSrc ? `<img src="${imgSrc}" alt="foto" class="foto-comentario">` : ''}
//         <div class="texto-comentario">${comentario}</div>
//       `;
//       commentsList.appendChild(div);
//     });
//   }

//   renderizarComentarios();

//   commentForm.addEventListener('submit', e => {
//     e.preventDefault();
//     const texto = commentForm.querySelector('textarea').value.trim();
//     if (!texto) return alert('Comentário vazio não é permitido.');

//     if (!post.comentarios) post.comentarios = [];
//     if (!post.comentariosAutor) post.comentariosAutor = [];
//     if (!post.comentariosFoto) post.comentariosFoto = [];

//     post.comentarios.push(texto);
//     post.comentariosAutor.push(usuarioLogado.apelido);
//     post.comentariosFoto.push(usuarioLogado.foto);

//     salvarPosts();
//     renderizarComentarios();
//     commentForm.reset();
//   });

//   const btnEditar = lightboxContent.querySelector('.editar-btn');
//   if (btnEditar) {
//     btnEditar.addEventListener('click', () => {
//       iniciarEdicao(index);
//       modalLightbox.style.display = 'none';
//     });
//   }

//   const btnExcluir = lightboxContent.querySelector('.excluir-btn');
//   if (btnExcluir) {
//     btnExcluir.addEventListener('click', () => {
//       if (confirm('Deseja realmente excluir este post?')) {
//         posts.splice(index, 1);
//         salvarPosts();
//         renderizarPosts();
//         modalLightbox.style.display = 'none';
//       }
//     });
//   }

//   modalLightbox.style.display = 'flex';
// }

// // Fechar lightbox com botão
// document.addEventListener('click', (e) => {
//   if (e.target.id === 'fechar-lightbox') {
//     modalLightbox.style.display = 'none';
//   }
// });

// // Iniciar edição
// function iniciarEdicao(index) {
//   const post = posts[index];
//   indiceEdicao = index;
//   formEditar.titulo.value = post.titulo;
//   formEditar.conteudo.value = post.conteudo;
//   modalEditar.style.display = 'block';
// }

// // Salvar edição
// formEditar.addEventListener('submit', e => {
//   e.preventDefault();
//   const novoTitulo = formEditar.titulo.value.trim();
//   const novoConteudo = formEditar.conteudo.value.trim();
//   if (!novoTitulo || !novoConteudo) {
//     alert('Preencha todos os campos!');
//     return;
//   }
//   posts[indiceEdicao].titulo = novoTitulo;
//   posts[indiceEdicao].conteudo = novoConteudo;
//   posts[indiceEdicao].data = Date.now();
//   salvarPosts();
//   renderizarPosts();
//   modalEditar.style.display = 'none';
// });

// // Novo post
// formPost.addEventListener('submit', e => {
//   e.preventDefault();
//   const titulo = formPost.titulo.value.trim();
//   const usuario = JSON.parse(localStorage.getItem('usuarioLogado'));
//   // if (!usuario) return alert('Usuário não está logado.');
//   const autor = usuario.apelido;
//   const conteudo = formPost.conteudo.value.trim();
//   if (!titulo || !autor || !conteudo) {
//     alert('Preencha todos os campos');
//     return;
//   }
//   posts.unshift({
//     titulo,
//     autor,
//     conteudo,
//     data: Date.now(),
//     comentarios: [],
//     comentariosAutor: [],
//     comentariosFoto: []
//   });
//   salvarPosts();
//   renderizarPosts();
//   formPost.reset();
//   modal.style.display = 'none';
// });

// // Salvar e carregar posts
// function salvarPosts() {
//   localStorage.setItem('posts', JSON.stringify(posts));
// }
// function carregarPosts() {
//   const dados = localStorage.getItem('posts');
//   if (dados) posts = JSON.parse(dados);
// }

// // Renderizar todos os posts
// function renderizarPosts() {
//   postsContainer.innerHTML = '';
//   posts.forEach((post, index) => {
//     const preview = criarPostPreview(post.titulo, post.autor, post.data, index);
//     postsContainer.appendChild(preview);
//   });
// }

// // Inicializar
// carregarPosts();
// renderizarPosts();
