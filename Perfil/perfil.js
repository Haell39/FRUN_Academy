const botaoEditar = document.querySelector('.edit-button');
const botaoSalvar = document.querySelector('.save-button');
const campos = document.querySelectorAll('.form-group input, .form-group select');
const inputFoto = document.getElementById('fotoUpload');
const imagemPerfil = document.getElementById('fotoPerfil');
const apelidoPerfil = document.getElementById('apelidoPerfil');
const labelFoto = document.getElementById('labelFoto');

function setCamposEditaveis(editavel) {
  campos.forEach(campo => campo.disabled = !editavel);
  labelFoto.style.cursor = editavel ? 'pointer' : 'default';
  labelFoto.style.pointerEvents = editavel ? 'auto' : 'none';
}

botaoEditar.addEventListener('click', () => {
  setCamposEditaveis(true);
  botaoEditar.style.display = 'none';
  botaoSalvar.style.display = 'inline-block';
});

botaoSalvar.addEventListener('click', () => {
  salvarNoLocalStorage();
  setCamposEditaveis(false);
  botaoSalvar.style.display = 'none';
  botaoEditar.style.display = 'inline-block';
});