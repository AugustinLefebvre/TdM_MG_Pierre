if (navigator.userAgent.match(/chrome/i) != null){ 

  var css = document.createElement('link');
  css.type = "text/css";
  css.rel = "stylesheet";
  css.href = "{{ asset('/css/mobile.css') }}";

  var h = document.getElementsByTagName('head')[0];
  h.appendChild(css);
}