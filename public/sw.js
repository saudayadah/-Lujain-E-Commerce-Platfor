// Service Worker - لُجين PWA
const CACHE_NAME = 'lujain-v1';
const RUNTIME_CACHE = 'lujain-runtime-v1';

// Assets to cache immediately
const PRECACHE_ASSETS = [
  '/',
  '/css/mobile.css',
  '/css/app.css',
  '/images/logo.png',
  '/images/favicon.png'
];

// Install Event - Cache Assets
self.addEventListener('install', (event) => {
  console.log('Service Worker: Installing...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Service Worker: Caching Files');
        return cache.addAll(PRECACHE_ASSETS);
      })
      .then(() => {
        console.log('Service Worker: Skip Waiting');
        return self.skipWaiting();
      })
      .catch((error) => {
        console.error('Service Worker: Cache Error', error);
      })
  );
});

// Activate Event - Clean Old Caches
self.addEventListener('activate', (event) => {
  console.log('Service Worker: Activating...');
  
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((cacheName) => {
            return cacheName !== CACHE_NAME && cacheName !== RUNTIME_CACHE;
          })
          .map((cacheName) => {
            console.log('Service Worker: Deleting Old Cache', cacheName);
            return caches.delete(cacheName);
          })
      );
    }).then(() => {
      console.log('Service Worker: Activated');
      return self.clients.claim();
    })
  );
});

// Fetch Event - Network First Strategy
self.addEventListener('fetch', (event) => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') {
    return;
  }

  // Skip external requests (API calls)
  if (event.request.url.includes('api') || 
      event.request.url.includes('payment') ||
      event.request.url.includes('cart')) {
    // Always fetch from network for dynamic content
    return fetch(event.request)
      .then((response) => {
        return caches.open(RUNTIME_CACHE).then((cache) => {
          cache.put(event.request, response.clone());
          return response;
        });
      })
      .catch(() => {
        return caches.match(event.request);
      });
  }

  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // Clone the response
        const responseToCache = response.clone();
        
        // Add to cache
        caches.open(RUNTIME_CACHE).then((cache) => {
          cache.put(event.request, responseToCache);
        });
        
        return response;
      })
      .catch(() => {
        // Network failed, try cache
        return caches.match(event.request);
      })
  );
});

// Push Notification Event
self.addEventListener('push', (event) => {
  console.log('Push Notification Received');
  
  const options = {
    body: event.data ? event.data.text() : 'إشعار جديد من لُجين',
    icon: '/images/icon-192x192.png',
    badge: '/images/badge.png',
    vibrate: [200, 100, 200],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    }
  };

  event.waitUntil(
    self.registration.showNotification('لُجين', options)
  );
});

// Notification Click Event
self.addEventListener('notificationclick', (event) => {
  console.log('Notification Clicked');
  
  event.notification.close();

  event.waitUntil(
    clients.openWindow('/')
  );
});

// Background Sync
self.addEventListener('sync', (event) => {
  console.log('Background Sync:', event.tag);
  
  if (event.tag === 'sync-cart') {
    event.waitUntil(
      // Sync cart data
      console.log('Syncing cart data...')
    );
  }
});

