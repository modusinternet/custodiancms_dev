/* In order to get the listed resources below to load properly once moved to Amazon's CloudFront servers you need to add this to your S3 bucket, under Permissions/CORS configuration:

<?xml version="1.0" encoding="UTF-8"?>
<CORSConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/">
	<CORSRule>
		<AllowedOrigin>https://PUTYOURDOMAINNAMEHERE.com</AllowedOrigin>
		<AllowedMethod>GET</AllowedMethod>
		<MaxAgeSeconds>3000</MaxAgeSeconds>
		<AllowedHeader>Authorization</AllowedHeader>
	</CORSRule>
</CORSConfiguration>


Then you need to select the appropriate distribution under CloudFront and click the Behaviors tab.  Create or Edit an existing Behavior and select the following settings:

Allowed HTTP Methods: GET, HEAD, OPTIONS

Enable 'Cached HTTP Methods': GET, HEAD and OPTIONS
NOTE: THIS IS A MAYBE, I HAVE TO LEARN MORE ABOUT THIS Setting

Cache Based on Selected Request Headers: Whitelist
Add these to the right box under Whitelist Headers, add as custom if necessary:
	Access-Control-Allow-Origin
	Access-Control-Request-Headers
	Access-Control-Request-Method
	Origin

Then click the 'Yes, Edit' button at the bottom and give it about 10 minutes to propagate through the system and test using Chrome.
*/


const cacheName = '2021-01-27.v02';


/*
Argument details for build_css_link2() and build_js_link() function calls:
arg1 = (1 = append AWS link), (empty = do not append AWS link)
arg2 = (1 = append language code to link), (empty = do not append language code to link)	In other words, send it through the parser first like a normal template.
arg3 = a variable found in the config file that represents a partial pathway to the style sheet, not including and details about AWS, language code, or language direction)
arg4 = (1 = append language direction to link), (empty = do not append language direction to link)
*/
var cacheFiles = [
	'/{CCMS_LIB:_default.php;FUNC:ccms_lng}/examples/offline.html',
	/*
	'/{CCMS_LIB:_default.php;FUNC:ccms_lng}/examples/manifest.html',
	'/ccmstpl/examples/_img/ico/apple-touch-icon.png',
	'/ccmstpl/examples/_img/ico/safari-pinned-tab.svg',
	'/ccmstpl/examples/_img/ico/favicon.ico',
	'/ccmstpl/examples/_img/ico/favicon-32x32.png',
	'/ccmstpl/examples/_img/ico/favicon-16x16.png',
	'/ccmstpl/examples/_js/main.js',
	'/ccmstpl/examples/_css/style.css'
	*/
];


/*
Analytics and Service Worker:
https://developers.google.com/web/ilt/pwa/integrating-analytics#analytics_and_service_worker
self.importScripts('/ccmstpl/examples/_js/analytics-helper.js');
*/


/*
Important resources used in the assembly of this services code:
https://googlechrome.github.io/samples/service-worker/custom-offline-page/
https://developers.google.com/web/updates/2017/02/navigation-preload
*/


self.addEventListener('install',(event) => {
	event.waitUntil((async() => {
		const cache = await caches.open(cacheName).then(cache => {
			return cache.addAll(cacheFiles);
		})
	})());
});


self.addEventListener('activate',(event) => {
	event.waitUntil((async() => {
		caches.keys().then(keyList => {
			return Promise.all(keyList.map(key => {
				if(key !== cacheName) return caches.delete(key);
			}));
		})
	})());
});


self.addEventListener('fetch',(event) => {
	event.respondWith((async() => {

		const cache = await caches.open(cacheName);

		try {
			const cachedResponse = await cache.match(event.request);
			if(cachedResponse) {
				console.log('cachedResponse: ', event.request.url);
				return cachedResponse;
			}

			/*const fetchResponse = await fetch(event.request);*/
			const fetchResponse = await fetch(event.request, {mode:'no-cors'});

			if(fetchResponse) {
				console.log('fetchResponse: ', event.request.url);
				/* Use this code below to preclude storing templates in cache that are located in the WordPress dirs. */
				/*if(!/blog\/wp\-/i.test(event.request.url)) {
					await cache.put(event.request, fetchResponse.clone());
				}*/
				await cache.put(event.request, fetchResponse.clone());
				return fetchResponse;
			}

		}	catch (error) {
			console.log('Fetch failed: ', error);
			const cachedResponse = await cache.match('/{CCMS_LIB:_default.php;FUNC:ccms_lng}/examples/offline.html');
			return cachedResponse;
		}
	})());
});
