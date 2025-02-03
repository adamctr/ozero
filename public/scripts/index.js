function showFlashMessage(data) {
  const flashMessageContainer = document.getElementById('flashMessageContainer');

  // Vérifie si l'élément existe
  if (!flashMessageContainer) {
    console.error("L'élément #flashMessageContainer est introuvable !");
    return;
  }

  // Suppression des anciens messages
  flashMessageContainer.innerHTML = '';

  // Mapping des statuts aux classes DaisyUI et SVG visibles
  const statusConfig = {
    success: {
      class: 'alert alert-success',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
              <path d="M5 13l4 4L19 7"></path>
            </svg>`
    },
    error: {
      class: 'alert alert-error',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`
    },
    info: {
      class: 'alert alert-info',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"></path>
            </svg>`
    },
    warning: {
      class: 'alert alert-warning',
      icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path>
            </svg>`
    }
  };

  // Récupération des classes et icônes (par défaut : info)
  const { class: alertClass, icon } = statusConfig[data.status] || statusConfig.info;

  // Création de l'élément HTML de l'alerte
  const alertElement = document.createElement('div');
  alertElement.role = 'alert';
  alertElement.className = `${alertClass} shadow-lg flex items-center gap-2 p-4`;

  alertElement.innerHTML = `
    <div class="flex items-center gap-2">
      ${icon}
      <span>${data.message}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="btn btn-sm btn-ghost ml-auto">✖</button>
  `;

  // Ajout de l'alerte dans le container
  flashMessageContainer.appendChild(alertElement);

  // Suppression automatique après 5 secondes
  setTimeout(() => {
    alertElement.remove();
  }, 5000);
}
