self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open('dans-attendance-v1').then(function (cache) {
            return cache.addAll([
                '/images/jkb.png',
            ]);
        })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request).catch(function () {
                return caches.match('offline');
            });
        })
    );
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.filter(function (cacheName) {
                    return cacheName.startsWith('dans-attendance-') && cacheName != 'dans-attendance-v1';
                }).map(function (cacheName) {
                    return caches.delete(cacheName);
                })
            );
        })
    );
});