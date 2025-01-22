const CACHE_NAME = "app-cache-v1";
const urlsToCache = [
    "/",
    "/manifest.json",
    "/css/app.css",
    "/js/app.js",
    "https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"
];

// Instalación del Service Worker
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Archivos en caché");
            return cache.addAll(urlsToCache);
        })
    );
});

// Interceptar solicitudes de red
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

// Actualizar el cache
self.addEventListener("activate", (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
