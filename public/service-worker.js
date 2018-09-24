var dataCacheName = 'ACIWEB_APP-v1';
var cacheName = 'ACIWEB_APP-v1';
/*var filesToCache = [
  '../',
  '../application/view/mobile/index.php',
  '../public/mobile_assets/images/apcon_icon.ico'];*/


  var filesToCache = [];
  
  self.addEventListener('install', function(e) {
    console.log('[ServiceWorker] Install');
    e.waitUntil(
      caches.open(cacheName).then(function(cache) {
        console.log('[ServiceWorker] Caching app shell');
        return cache.addAll(filesToCache);
      })
    );
  });
  

  self.addEventListener('activate', function(e) {
    console.log('[ServiceWorker] Activate');
    e.waitUntil(
      caches.keys().then(function(keyList) {
        return Promise.all(keyList.map(function(key) {
          if (key !== cacheName) {
            console.log('[ServiceWorker] Removing old cache', key);
            return caches.delete(key);
          }
        }));
      })
    );
   // return self.clients.claim();
  });