/* Loading Screen START */
window.setTimeout(function(){
	document.getElementById("loading_svg").style.opacity="0";
	window.setTimeout(function(){
		document.getElementById("loading_svg").style.display="none";
	},500);
},500);
window.setTimeout(function(){
	document.getElementsByTagName("body")[0].style.opacity="1";
},250);
/* Loading Screen END */


/* Active link selector START */
try{
	activeArray_01.forEach(function(id){
		var element = document.getElementById(id);
		element.classList.add("active");
	})
	activeArray_02.forEach(function(id){
		var element = document.getElementById(id);
		element.classList.add("active");
	})
}catch(e){
	/*console.log(e);*/
}
/* Active link selector END */


/* Lazyload Images START */
var lazyloadImages;
if("IntersectionObserver" in window){
	lazyloadImages = document.querySelectorAll(".lazy");
	var imageObserver = new IntersectionObserver(function(entries, observer){
		entries.forEach(function(entry){
			if(entry.isIntersecting){
				var image = entry.target;
				image.src = image.dataset.src;
				image.classList.remove("lazy");
				imageObserver.unobserve(image);
			}
		});
	});
	lazyloadImages.forEach(function(image){
		imageObserver.observe(image);
	});
} else {
	var lazyloadThrottleTimeout;
	lazyloadImages = document.querySelectorAll(".lazy");
	function lazyload(){
		if(lazyloadThrottleTimeout){
			clearTimeout(lazyloadThrottleTimeout);
		}
		lazyloadThrottleTimeout = setTimeout(function(){
			var scrollTop = window.pageYOffset;
			lazyloadImages.forEach(function(img){
					if(img.offsetTop < (window.innerHeight + scrollTop)){
						img.src = img.dataset.src;
						img.classList.remove('lazy');
					}
			});
			if(lazyloadImages.length == 0){
				document.removeEventListener("scroll",lazyload);
				window.removeEventListener("resize",lazyload);
				window.removeEventListener("orientationChange",lazyload);
			}
		},20);
	}
	document.addEventListener("scroll",lazyload);
	window.addEventListener("resize",lazyload);
	window.addEventListener("orientationChange",lazyload);
}
/* Lazyload Images END */


/* General Data Protection Regulation (GDPR) Cookie Consent Banner START */
window.wpcc.init({"colors":{"popup":{"background":"#ffe4e1","text":"#000000","border":"var(--cl3)"},"button":{"background":"var(--cl3)","text":"#ffffff"}},"position":"bottom","padding":"none","fontsize":"tiny","content":{"href":"/en/about-us/privacy-policy.html","message":"This site uses cookies to help maintain session persistance and language preferences. Services such as Google also place cookies here to help us improve your experience by providing insights into how the site is being used."}})
/* General Data Protection Regulation (GDPR) Cookie Consent Banner END */


/* Add to Home screen (A2HS) START
https://developer.mozilla.org/en-US/docs/Web/Apps/Progressive/Add_to_home_screen#How_do_you_make_an_app_A2HS-ready */
function getCookie(cname){
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++){
		var c = ca[i];
		while(c.charAt(0) == ' '){
			c = c.substring(1);
		}
		if(c.indexOf(name) == 0){
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
let a2Cookie;
let deferredPrompt;
const A2HSbox = document.getElementById("A2HS-box");
const A2HSbox_no = document.getElementById("A2HS-box-no");
const A2HSbox_yes = document.getElementById("A2HS-box-yes");
window.addEventListener("beforeinstallprompt",e =>{
	a2Cookie = getCookie("A2HSbox");
	/* Test for A2HSbox cookie. */
	if(a2Cookie == ""){
		/* A2HSbox cookie not found so run 'beforeinstallprompt' event detection code. */
		console.log('A2HSbox cookie not found and "beforeinstallprompt" event detected, dropping A2HS box.');
		/* Prevent Chrome 67 and earlier from automatically showing the prompt. */
		e.preventDefault();
		/* Stash the event so it can be triggered later. */
		deferredPrompt = e;
		/* Update UI to notify the user they can add to home screen. */
		A2HSbox.classList.add("active");

		A2HSbox_no.addEventListener('click',e =>{
			console.log('User dismissed A2HS prompt #1.');
			/* hide our user interface that shows our A2HS button. */
			A2HSbox.classList.remove("active");
			/* Set cookie to defer A2HS box apearence in the future.	(15768000 = 6 months) */
			document.cookie = "A2HSbox=1; max-age=15768000; path=/";
			deferredPrompt = null;
		});

		A2HSbox_yes.addEventListener('click',e =>{
			console.log('User accepted A2HS prompt #1.');
			/* hide our user interface that shows our A2HS button. */
			A2HSbox.classList.remove("active");
			/* Show the prompt. */
			deferredPrompt.prompt();
			/* Wait for the user to respond to the prompt. */
			deferredPrompt.userChoice.then(choiceResult =>{
				if (choiceResult.outcome === 'accepted') {
					console.log('User accepted A2HS prompt #2.');
				} else {
					console.log('User dismissed A2HS prompt #2.');
					/* Set cookie to defer A2HS box apearence in the future.	(15768000 = 6 months) */
					document.cookie = "A2HSbox=1; max-age=15768000; path=/";
				}
				deferredPrompt = null;
			});
		});
	}
});
/* Add to Home Screen (A2HS) END */
