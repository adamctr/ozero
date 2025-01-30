document.addEventListener('DOMContentLoaded', () => {
  // Fonction pour remplir le formulaire d'édition avec les données de la catégorie
  function populateEditForm(button) {
    const categoryId = button.getAttribute('data-category-id');
    const name = button.getAttribute('data-name');
    const parentCategoryId = button.getAttribute('data-parent-category-id');

    document.getElementById('edit-category-id').value = categoryId;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-parent-category-id').value = parentCategoryId;
  }

  // Fonction pour remplir le formulaire de suppression avec l'ID de la catégorie
  function populateDeleteForm(button) {
    const categoryId = button.getAttribute('data-category-id');
    document.getElementById('delete-category-id').value = categoryId;
  }

  // Sélectionner tous les boutons de modification et de suppression
  const editButtons = document.querySelectorAll('.btn-info');
  const deleteButtons = document.querySelectorAll('.btn-error');

  // Attacher l'événement de clic aux boutons "Modifier"
  editButtons.forEach(button => {
    button.addEventListener('click', function() {
      populateEditForm(this);
    });
  });

  // Attacher l'événement de clic aux boutons "Supprimer"
  deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
      populateDeleteForm(this);
      document.getElementById('delete-category-modal').checked = true; // Ouvrir le modal de suppression
    });
  });
});
