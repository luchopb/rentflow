self.addEventListener('install', function(event) {
    console.log('Service Worker: Instalando...');
  });
  
  self.addEventListener('activate', function(event) {
    console.log('Service Worker: Activado');
  });
  
  self.addEventListener('fetch', function(event) {
    console.log('Service Worker: Fetching', event.request.url);
  });
  