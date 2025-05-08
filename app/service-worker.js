const cacheName = 'pwa-cache-v1';
const filesToCache = [
  'index.php',
  'sobre.php',
  'contact.php',
  'styles/style.css',
  'js/app.js',
  'manifest.json',
  'images/logo.png',
  'list.php',
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
