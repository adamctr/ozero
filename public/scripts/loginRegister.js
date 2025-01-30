document.addEventListener('DOMContentLoaded', function() {
  // Vérification si loginForm existe avant d'ajouter l'événement
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();

      let email = document.getElementById('email').value;
      let password = document.getElementById('password').value;
      let remember = document.getElementById('remember').checked;

      // Effectuer une requête AJAX pour valider le mot de passe
      fetch('/login', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&remember=${encodeURIComponent(remember)}`
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);

          if (data.status === 'success') {
            window.location.href = '/';
          }
          const messageContainer = document.getElementById('messageContainer');
          messageContainer.innerHTML = data.divMessageHtml;
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  }

  // Vérification si registerForm existe avant d'ajouter l'événement
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
      e.preventDefault();

      let email = document.getElementById('email').value;
      let password = document.getElementById('password').value;
      let username = document.getElementById('name').value;
      let firstName = document.getElementById('firstName').value;
      let lastName = document.getElementById('lastName').value;

      // Effectuer une requête AJAX pour l'inscription
      fetch('/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&name=${encodeURIComponent(username)}&firstName=${encodeURIComponent(firstName)}&lastName=${encodeURIComponent(lastName)}`
      })
        .then(response => response.json())
        .then(data => {

          if (data.status === 'success') {
            // Rediriger vers une autre page après inscription réussie
            window.location.href = '/';
          }

          // Afficher le message d'erreur ou de succès dans le conteneur
          const messageContainer = document.getElementById('messageContainer');
          messageContainer.innerHTML = data.divMessageHtml;
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  }

  // Désactiver redirect lors du log-out
  const logoutForm = document.getElementById('logoutForm');
  if (logoutForm) {
    logoutForm.addEventListener('submit', function(e) {
      e.preventDefault();
    })
  }
});


