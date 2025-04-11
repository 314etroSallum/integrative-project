const cacheName = 'pwa-cache-v1';
const filesToCache = [
  'index.html',
  'sobre.html',
  'contact.html',
  'styles/style.css',
  'js/app.js',
  'manifest.json',
  'images/logo.png',
  'correia.html',
  'disco.html',
  'inov.html',
  'lampada.html',
  'Moura.html',
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(cacheName).then(cache => {
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
