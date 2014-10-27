jQuery(document).ready(function($){

function mediaQueryClass(width) {
   if (width > 641) { //PC

     $("#stylesheet").attr('href',$("#stylesheet").attr('href').replace("style_sp.css","style_pc.css"));

   } else { //ÉXÉ}Éz

     $("#stylesheet").attr('href',$("#stylesheet").attr('href').replace("style_pc.css","style_sp.css"));

   };
};

mediaQueryClass(document.documentElement.clientWidth);

$(window).bind('resize orientationchange', function() {
  mediaQueryClass(document.documentElement.clientWidth);
})


});