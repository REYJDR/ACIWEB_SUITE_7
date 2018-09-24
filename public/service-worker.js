var dataCacheName = 'ACIWEB_APP-v1';
var cacheName = 'ACIWEB_APP-v1';
var filesToCache = [
  '../',
  '../application/view/mobile/index.php',
  '../public/mobile_assets/images/apcon_icon.ico'];
  
 /* self.addEventListener('install', function(e) {
    console.log('[ServiceWorker] Install');
    e.waitUntil(
      caches.open(cacheName).then(function(cache) {
        console.log('[ServiceWorker] Caching app shell');
        return cache.addAll(filesToCache);
      })
    );
  });*/

  self.addEventListener('activate', function(e) {
    console.log('[ServiceWorker] Activate');
  });