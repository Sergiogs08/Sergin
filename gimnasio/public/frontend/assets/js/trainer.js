// Inicialización mínima del calendario (puedes integrar FullCalendar o similar)
document.addEventListener('DOMContentLoaded', () => {
  const cal = document.getElementById('calendar');
  if (!cal) return;

  cal.innerHTML = `
    <div class="month-nav">
      <button id="prevMonth">&lt;</button>
      <span id="monthYear"></span>
      <button id="nextMonth">&gt;</button>
    </div>
    <table class="calendar-table">
      <thead><tr>
        <th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th>
      </tr></thead>
      <tbody id="calBody"></tbody>
    </table>
  `;

  let now = new Date();
  function render(monthDate) {
    const year = monthDate.getFullYear();
    const month = monthDate.getMonth();
    document.getElementById('monthYear').textContent = 
      monthDate.toLocaleString('es',{month:'long', year:'numeric'});
    const firstDay = new Date(year, month, 1).getDay() || 7; // Lunes=1..Dom=7
    const days = new Date(year, month+1, 0).getDate();
    let html = '<tr>';
    for(let i=1; i<firstDay; i++) html += '<td></td>';
    for(let d=1; d<=days; d++) {
      if ((firstDay + d -1) % 7 === 1) html += '</tr><tr>';
      html += `<td>${d}</td>`;
    }
    html += '</tr>';
    document.getElementById('calBody').innerHTML = html;
  }

  document.getElementById('prevMonth').onclick = () => {
    now.setMonth(now.getMonth()-1);
    render(now);
  };
  document.getElementById('nextMonth').onclick = () => {
    now.setMonth(now.getMonth()+1);
    render(now);
  };

  render(now);
});

