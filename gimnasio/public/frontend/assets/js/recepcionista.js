document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tabs button');
  const contents = document.querySelectorAll('.tab-content');
  const searchInput = document.getElementById('search');
  const filterSelect = document.getElementById('filter-role');
  const rows = document.querySelectorAll('tbody tr');

  // cambiar pestañas
  tabs.forEach(btn => btn.addEventListener('click', () => {
    tabs.forEach(b => b.classList.remove('active'));
    contents.forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab).classList.add('active');
  }));

  // debounce
  const debounce = (fn, delay = 300) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn(...args), delay);
    };
  };

  // filtrar usuarios
  const filterUsers = () => {
    const term = searchInput.value.trim().toLowerCase();
    const role = filterSelect.value;
    rows.forEach(r => {
      const name = r.cells[1].textContent.toLowerCase();
      const matchTerm = name.includes(term);
      const matchRole = role === 'all' || r.dataset.role === role;
      r.style.display = matchTerm && matchRole ? '' : 'none';
    });
  };

  searchInput.addEventListener('input', debounce(filterUsers));
  filterSelect.addEventListener('change', filterUsers);
});
