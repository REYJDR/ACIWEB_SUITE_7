
  var cacheName = 'ACIWEB APP';
  var filesToCache = ['/',
  '/application',
  '/application/view/mobile/',
  '/public',
  '/public/mobile_assets/'];
  
  self.addEventListener('install', function(e) {
    console.log('[ServiceWorker] Install');
    e.waitUntil(
      caches.open(cacheName).then(function(cache) {
        console.log('[ServiceWorker] Caching app shell');
        return cache.addAll(filesToCache);
      })
    );
  });
