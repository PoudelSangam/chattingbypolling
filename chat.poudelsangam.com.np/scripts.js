let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    console.log('beforeinstallprompt fired'); // Add this line
    e.preventDefault();
    deferredPrompt = e;
    showInstallModal();
});


function showInstallModal() {
  const installModal = document.getElementById('installModal');
  installModal.classList.remove('hidden');

  document.getElementById('installAppButton').addEventListener('click', () => {
    installModal.classList.add('hidden');
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the install prompt');
      } else {
        console.log('User dismissed the install prompt');
      }
      deferredPrompt = null;
    });
  });

  document.getElementById('closeModalButton').addEventListener('click', () => {
    installModal.classList.add('hidden');
  });
}
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            })
            .catch(error => {
                console.log('ServiceWorker registration failed: ', error);
            });
    });
}
