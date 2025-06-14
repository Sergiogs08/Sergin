// public/frontend/assets/js/login.js

document.addEventListener('DOMContentLoaded', () => {
  // Sólo toggle de contraseña, nada más
  const passwordField = document.getElementById('password');
  const toggleButton  = document.getElementById('togglePassword');
  if (!passwordField || !toggleButton) return;

  toggleButton.addEventListener('click', () => {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
  });
});

