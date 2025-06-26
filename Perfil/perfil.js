// Perfil/perfil.js

const botaoEditar = document.querySelector('.edit-button');
const botaoSalvar = document.querySelector('.save-button');
// Seleciona os inputs e selects dentro do formulário que são editáveis
const camposEditaveis = document.querySelectorAll('#profileForm .form-group input, #profileForm .form-group select');
const inputFoto = document.getElementById('fotoUpload');
const imagemPerfil = document.getElementById('fotoPerfil');
const labelFoto = document.getElementById('labelFoto'); // O label que envolve a imagem de perfil
const profileForm = document.getElementById('profileForm'); // Referência ao formulário completo

// Função para habilitar/desabilitar campos e o upload de foto
function setCamposEditaveis(editavel) {
  camposEditaveis.forEach(campo => {
    // Apelido não deve ser editável, a menos que haja lógica complexa de backend para isso
    if (campo.name !== 'apelido_display_only') { // Exclui o campo de apelido se ele for apenas para display
      campo.disabled = !editavel;
    }
  });

  // Habilita/desabilita o input de upload de foto e o cursor do label
  if (inputFoto) { // Verifica se inputFoto existe
    inputFoto.disabled = !editavel;
  }
  if (labelFoto) { // Verifica se labelFoto existe
    labelFoto.style.cursor = editavel ? 'pointer' : 'default';
    labelFoto.style.pointerEvents = editavel ? 'auto' : 'none'; // Permite/bloqueia cliques
  }
}

// Event listener para o botão "Editar"
if (botaoEditar) {
  botaoEditar.addEventListener('click', () => {
    setCamposEditaveis(true); // Habilita a edição dos campos
    botaoEditar.style.display = 'none'; // Esconde o botão "Editar"
    botaoSalvar.style.display = 'inline-block'; // Mostra o botão "Salvar"
  });
}


// Event listener para o botão "Salvar"
// Agora o botão Salvar fará o SUBMIT do formulário, o PHP vai lidar com o salvamento.
if (botaoSalvar) {
  botaoSalvar.addEventListener('click', (e) => {
    // Não é mais necessário chamar salvarNoLocalStorage()
    // O formulário será submetido e a página recarregará ou redirecionará via PHP
    // Se houver validações adicionais em JS, elas viriam aqui ANTES do submit

    // Se tudo estiver OK para submeter:
    profileForm.submit(); // Dispara o submit do formulário

    // Após o submit, a página recarregará ou será redirecionada pelo PHP.
    // O estado dos botões será redefinido pelo PHP na próxima carga da página.
    // setCamposEditaveis(false); // Essa linha será gerenciada pelo PHP/recarga
    // botaoSalvar.style.display = 'none'; // Essa linha será gerenciada pelo PHP/recarga
    // botaoEditar.style.display = 'inline-block'; // Essa linha será gerenciada pelo PHP/recarga
  });
}

// Lógica para pré-visualizar a imagem selecionada (opcional)
if (inputFoto && imagemPerfil) {
  inputFoto.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (event) => {
        imagemPerfil.src = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
}

// Inicializa o estado dos campos como desabilitados ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
  setCamposEditaveis(false);
  // Certifica-se de que o botão salvar esteja escondido e editar visível ao carregar
  if (botaoSalvar) botaoSalvar.style.display = 'none';
  if (botaoEditar) botaoEditar.style.display = 'inline-block';
});

// A função salvarNoLocalStorage() foi removida pois o salvamento será via PHP.
// As referências a apelidoPerfil também foram removidas, pois o PHP preenche diretamente o HTML.