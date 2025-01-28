document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.getElementsByClassName('delete-user-btn')

  for (let i = 0; i < buttons.length; i++) {
    const button = buttons[i];
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const userId = e.target.dataset.id;

      fetch('/user/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ userId: userId })
      }).then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert('Utilisateur supprimé avec succès');
          } else {
            alert('Erreur lors de la suppression de l\'utilisateur');
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          alert('Une erreur s\'est produite');
        });

    })
  }
})
