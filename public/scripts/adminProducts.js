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

// Ajouter Produit
document.addEventListener("DOMContentLoaded", function () {
  const productForm = document.getElementById("productForm");

  if (productForm) {
    productForm.addEventListener("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      fetch("/admin/products/add", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            alert("Produit ajouté avec succès !");
            productForm.reset();
          } else {
            alert("Erreur : " + data.message);
          }

          showFlashMessage(data)
          closeAllModals()


        })
        .catch(error => {
          console.error("Erreur AJAX :", error);
          alert("Une erreur est survenue lors de l'ajout du produit.");
        });
    });
  }
});
