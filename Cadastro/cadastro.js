function toggleSenha(idCampo, elemento) {
    const campo = document.getElementById(idCampo);
    const icone = elemento.querySelector('i');
    const isPassword = campo.type === 'password';
    campo.type = isPassword ? 'text' : 'password';
    icone.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
  }