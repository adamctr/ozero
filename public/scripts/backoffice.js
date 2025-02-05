// Utils

function closeAllModals() {
  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    modal.style.display = 'none'; // Si le modal est géré par CSS (affichage/masquage)
    modal.classList.remove('show'); // Pour Bootstrap ou modals CSS de ce genre
  });
}

// Sidebar

document.addEventListener('DOMContentLoaded', () => {

  document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
  });

})


