document.addEventListener('DOMContentLoaded', () => {

  document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
  });

})
