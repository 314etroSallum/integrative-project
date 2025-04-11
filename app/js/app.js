if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js')
      .then(() => console.log("Service Worker registrado com sucesso"))
      .catch(err => console.error("Erro ao registrar Service Worker:", err));
  }
  