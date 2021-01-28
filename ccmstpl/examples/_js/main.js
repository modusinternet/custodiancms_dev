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


/* Active link selector BEGIN */
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


/* Lazyload Images BEGIN */
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
