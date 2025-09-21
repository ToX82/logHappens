const CACHE_NAME = 'loghappens-v1.0.0';
const STATIC_CACHE = 'loghappens-static-v1.0.0';
const DYNAMIC_CACHE = 'loghappens-dynamic-v1.0.0';

// Risorse da mettere in cache immediatamente
const STATIC_ASSETS = [
  '/',
  '/css/layout.css',
  '/js/custom.js',
  '/img/logo.png',
  '/img/favicon/favicon-32x32.png',
  '/img/favicon/apple-touch-icon-152x152.png',
  'https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/datatables.net-bs4@1/css/dataTables.bootstrap4.min.css',
  'https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js',
  'https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.min.js',
  'https://cdn.jsdelivr.net/npm/datatables.net@1/js/jquery.dataTables.min.js',
  'https://cdn.jsdelivr.net/npm/datatables.net-bs4@1/js/dataTables.bootstrap4.min.js',
  'https://cdn.jsdelivr.net/npm/push.js@1/bin/push.min.js',
  'https://cdn.jsdelivr.net/npm/iconify-select-plugin@1/iconify-select-plugin.min.js',
  'https://cdn.jsdelivr.net/npm/mark.js@8/dist/jquery.mark.min.js',
  'https://cdn.jsdelivr.net/npm/@iconify/iconify@1/dist/iconify.min.js'
];

// Install event - cache static assets
self.addEventListener('install', event => {
    console.log('[SW] Installing service worker...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
        .then(cache => {
            console.log('[SW] Caching static assets');
            return cache.addAll(STATIC_ASSETS);
        })
        .then(() => {
            console.log('[SW] Static assets cached successfully');
            return self.skipWaiting();
        })
        .catch(error => {
            console.error('[SW] Error caching static assets:', error);
        })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
    console.log('[SW] Activating service worker...');
    event.waitUntil(
        caches.keys()
        .then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE) {
                        console.log('[SW] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
        .then(() => {
            console.log('[SW] Service worker activated');
            return self.clients.claim();
        })
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

  // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }

  // Skip chrome-extension and other non-http requests
    if (!url.protocol.startsWith('http')) {
        return;
    }

  // Handle API requests differently
    if (url.pathname.includes('ajax.php') || url.pathname.includes('api/')) {
        event.respondWith(
            fetch(request)
            .then(response => {
            // Cache successful API responses
                if (response.ok) {
                    const responseClone = response.clone();
                    caches.open(DYNAMIC_CACHE)
                    .then(cache => cache.put(request, responseClone));
                }
                return response;
            })
            .catch(() => {
            // Return cached version if available
                return caches.match(request);
            })
        );
        return;
    }

  // For static assets, try cache first, then network
    event.respondWith(
        caches.match(request)
        .then(cachedResponse => {
            if (cachedResponse) {
                console.log('[SW] Serving from cache:', request.url);
                return cachedResponse;
            }

            return fetch(request)
            .then(response => {
              // Don't cache non-successful responses
                if (!response || response.status !== 200 || response.type !== 'basic') {
                    return response;
                }

              // Clone the response
                const responseToCache = response.clone();

              // Cache the response
                caches.open(DYNAMIC_CACHE)
                .then(cache => {
                    cache.put(request, responseToCache);
                    console.log('[SW] Cached new resource:', request.url);
                });

            return response;
            })
          .catch(error => {
                console.error('[SW] Fetch failed:', error);

            // Return offline page for navigation requests
                if (request.mode === 'navigate') {
                    return caches.match('/offline.html');
                }

                return new Response('Network error', {
                    status: 503,
                    statusText: 'Service Unavailable',
                    headers: new Headers({
                        'Content-Type': 'text/plain'
                    })
                });
            });
        })
    );
});

// Background sync for offline actions
self.addEventListener('sync', event => {
    console.log('[SW] Background sync triggered:', event.tag);

    if (event.tag === 'background-sync') {
        event.waitUntil(
        // Handle any pending background sync operations
            console.log('[SW] Processing background sync...')
        );
    }
});

// Push notification handling
self.addEventListener('push', event => {
    console.log('[SW] Push notification received');

    const options = {
        body: event.data ? event.data.text() : 'New log entry detected',
        icon: '/img/favicon/icon-192x192.png',
        badge: '/img/favicon/icon-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
        {
            action: 'explore',
            title: 'View Logs',
            icon: '/img/favicon/icon-96x96.png'
        },
        {
            action: 'close',
            title: 'Close',
            icon: '/img/favicon/icon-96x96.png'
        }
        ]
    };

    event.waitUntil(
        self.registration.showNotification('LogHappens', options)
    );
});

// Notification click handling
self.addEventListener('notificationclick', event => {
    console.log('[SW] Notification clicked:', event.action);

    event.notification.close();

    if (event.action === 'explore') {
        event.waitUntil(
            clients.openWindow('/?view=logs')
        );
    }
});

// Message handling for communication with main thread
self.addEventListener('message', event => {
    console.log('[SW] Message received:', event.data);

    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});