/* Navegación básica sin recargar (solo para demo interna) */
document.querySelectorAll('a[data-link]').forEach(a=>{
  a.addEventListener('click',e=>{
    e.preventDefault();
    window.location.href=a.getAttribute('href');
  });
});

/* Helper para cerrar sesión en todos los paneles */
export function logout(){
  fetch('/api/logout',{method:'POST',credentials:'include'}).finally(()=>{
    window.location.href='/auth/login.html';
  });
}
