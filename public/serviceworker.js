self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open('dans-attendance-v1').then(function (cache) {
            return cache.addAll([
                '/',
                '/offline',
                '/css/app.css',
                '/js/app.js',
                '/images/icons/icon-72x72.png',
                '/images/icons/icon-96x96.png',
                '/images/icons/icon-128x128.png',
                '/images/icons/icon-144x144.png',
                '/images/icons/icon-152x152.png',
                '/images/icons/icon-192x192.png',
                '/images/icons/icon-384x384.png',
                '/images/icons/icon-512x512.png',
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