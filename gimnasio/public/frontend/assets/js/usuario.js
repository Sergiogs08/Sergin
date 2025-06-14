// public/frontend/assets/js/usuario.js

document.addEventListener('DOMContentLoaded', () => {
  // Slider galería (si sigue en uso)
  const track   = document.querySelector('.gallery-track');
  const prevBtn = document.querySelector('.gallery-prev');
  const nextBtn = document.querySelector('.gallery-next');
  if (track && prevBtn && nextBtn) {
    const slides     = Array.from(track.querySelectorAll('.slide'));
    const gap        = 10;
    const slideWidth = slides[0].getBoundingClientRect().width + gap;
    let index = 0;

    prevBtn.addEventListener('click', () => {
      index = Math.max(index - 1, 0);
      track.scrollTo({ left: index * slideWidth, behavior: 'smooth' });
    });
    nextBtn.addEventListener('click', () => {
      index = Math.min(index + 1, slides.length - 1);
      track.scrollTo({ left: index * slideWidth, behavior: 'smooth' });
    });
  }

  // Lógica de “Contratar”
  const planValueEl = document.getElementById('plan-value');
  const buttons     = document.querySelectorAll('.subscribe-btn');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Resetear todos
      buttons.forEach(b => {
        b.disabled = false;
        b.textContent = 'Contratar';
        b.classList.remove('subscribed');
      });

      // Marcar seleccionado
      btn.disabled = true;
      btn.textContent = 'Contratado';
      btn.classList.add('subscribed');

      // Actualizar KPI
      const planName = btn.getAttribute('data-plan');
      if (planValueEl) planValueEl.textContent = planName;
    });
  });
});

