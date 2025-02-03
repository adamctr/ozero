document.addEventListener('DOMContentLoaded', () => {
  // Fonction pour remplir le formulaire d'édition avec les données du produit
  function populateEditForm(button) {
    const productId = button.getAttribute('data-product-id');
    const name = button.getAttribute('data-product');
    const description = button.getAttribute('data-description');
    const price = button.getAttribute('data-price');
    const stock = button.getAttribute('data-stock');

    document.getElementById('edit-product-id').value = productId;
    document.getElementById('edit-product').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-stock').value = stock;
  }

  // Fonction pour remplir le formulaire de suppression avec l'ID du produit
  function populateDeleteForm(button) {
    const productId = button.getAttribute('data-product-id');
    document.getElementById('delete-product-id').value = productId;
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
      document.getElementById('delete-product-modal').checked = true; // Ouvrir le modal de suppression
    });
  });
});
