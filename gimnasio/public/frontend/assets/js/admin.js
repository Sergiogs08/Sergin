// public/frontend/assets/js/admin.js
document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('chartUsuarios').getContext('2d');
  const labels = Object.keys(usuariosPorMes);
  const data   = Object.values(usuariosPorMes);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Usuarios',
        data,
        borderColor: '#55d7ff',
        backgroundColor: 'rgba(85,215,255,0.2)',
        fill: true,
        tension: 0.3,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(255,255,255,0.1)' },
          ticks: { color: '#eef2f7' }
        },
        x: {
          grid: { display: false },
          ticks: { color: '#eef2f7' }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#222',
          titleColor: '#55d7ff',
          bodyColor: '#fff'
        }
      }
    }
  });
});

