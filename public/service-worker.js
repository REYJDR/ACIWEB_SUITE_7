var cacheName = 'ACIWEB APP';


 self.addEventListener('activate', function(event) {
    console.log('[ServiceWorker] Activated');
    event.waitUntil(
      caches.open(cacheName).then(function(cache) {
        return cache.addAll([
          '/',
          '/application',
          '/application/view/mobile/',
          '/public',
          '/public/mobile_assets/'
        ]);
      })
    );
  });

  
