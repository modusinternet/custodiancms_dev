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


/* Lazyload Background Images Begin */
//document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");
  var lazyloadThrottleTimeout;

  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }

    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) {
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }

  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
//});
/* Lazyload Background Images End */
