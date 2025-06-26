const toggleSenha = document.getElementById('toggleSenha');
const senhaInput = document.getElementById('senha');
const iconeSenha = document.getElementById('iconeSenha');

toggleSenha.addEventListener('click', () => {
  const visivel = senhaInput.type === 'text';

  senhaInput.type = visivel ? 'password' : 'text';
  iconeSenha.classList.toggle('bi-eye', visivel);        // mostra olho aberto se ocultando
  iconeSenha.classList.toggle('bi-eye-slash', !visivel); // mostra olho cortado se visível
});