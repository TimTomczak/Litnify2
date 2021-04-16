import {registerRoute} from 'workbox-routing';
import {CacheFirst, StaleWhileRevalidate} from 'workbox-strategies';
import {precacheAndRoute} from "workbox-precaching";
import {ExpirationPlugin} from 'workbox-expiration';
import {CacheableResponsePlugin} from 'workbox-cacheable-response';
import {skipWaiting} from "workbox-core";
import * as navigationPreload from 'workbox-navigation-preload';
import {NavigationRoute} from 'workbox-routing';
import {NetworkOnly} from 'workbox-strategies';

precacheAndRoute(self.__WB_MANIFEST);
// precacheAndRoute([
//     {url: '/js/app.js', revision: 'null' },
//     // {url: '/styles/app.0c9a31.css', revision: null},
// ]);

// registerRoute(
//     new RegExp('.(?:js|css|ico)$'),
//     new NetworkFirst({
//         cacheName: 'staticCache'
//     }),
// )

// Cache the Google Fonts stylesheets with a stale-while-revalidate strategy.
registerRoute(
    ({url}) => url.origin === 'https://fonts.googleapis.com',
    new StaleWhileRevalidate({
        cacheName: 'google-fonts-stylesheets',
    })
);

// Cache the underlying font files with a cache-first strategy for 1 year.
registerRoute(
    ({url}) => url.origin === 'https://fonts.gstatic.com',
    new CacheFirst({
        cacheName: 'google-fonts-webfonts',
        plugins: [
            new CacheableResponsePlugin({
                statuses: [0, 200],
            }),
            new ExpirationPlugin({
                maxAgeSeconds: 60 * 60 * 24 * 365,
                maxEntries: 30,
            }),
        ],
    })
);

//JavaScript & CSS caching
registerRoute(
    ({request}) => request.destination === 'script' ||
        request.destination === 'style',
    new StaleWhileRevalidate({
        cacheName: 'static-resources',
    })
);

// Images caching
registerRoute(
    ({request}) => request.destination === 'image',
    new CacheFirst({
        cacheName: 'images',
        plugins: [
            new ExpirationPlugin({
                maxEntries: 60,
                maxAgeSeconds: 37 * 24 * 60 * 60, // 7 Days
            }),
        ],
    })
);



// registerRoute(
//     ({url}) => url.origin === self.location.origin &&
//         url.pathname.includes('/impressum/'),
//     new StaleWhileRevalidate({
//         cacheName: 'static-pages',
//         plugins: [
//             new ExpirationPlugin({
//                 maxEntries: 60,
//                 maxAgeSeconds: 24 * 60 * 60, // 1 Day
//             }),
//         ],
//     })
// );

registerRoute(
    new RegExp('(?:datenschutz|kontakt|oeffnungszeiten|faq|impressum|credits)'),
    new CacheFirst({
        cacheName: 'static-pages',
        plugins: [
            new ExpirationPlugin({
                maxEntries: 60,
                // maxAgeSeconds: 24 * 60 * 60, // 1/2 Day
                maxAgeSeconds: 60 * 60, // 1 hour
            }),
        ],
    })
);

//OFFLINE PAGE

const CACHE_NAME = 'offline-html';
// This assumes /offline.html is a URL for your self-contained
// (no external images or styles) offline page.
const FALLBACK_HTML_URL = '/offline.html';
const FALLBACK_HTML_BACKGROUND = '/img/offline.svg'
// Populate the cache with the offline HTML page when the
// service worker is installed.
self.addEventListener('install', async (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(
                (cache) => cache.add(FALLBACK_HTML_URL),
            )
    );
});

navigationPreload.enable();

const networkOnly = new NetworkOnly();
const navigationHandler = async (params) => {
    try {
        // Attempt a network request.
        return await networkOnly.handle(params);
    } catch (error) {
        // If it fails, return the cached HTML.
        return caches.match(FALLBACK_HTML_URL, {
            cacheName: CACHE_NAME,
        });
    }
};

// Register this strategy to handle all navigations.
registerRoute(
    new NavigationRoute(navigationHandler)
);
