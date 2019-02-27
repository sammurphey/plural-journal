(function($){
  //smooth scroll
  $('a[href*=#]:not([href=#])').on("click",function(){
    if(location.pathname.replace(/^\//,'')==this.pathname.replace(/^\//,'')&&location.hostname==this.hostname){
    var target=$(this.hash);
    target=target.length?target:$('[name='+this.hash.slice(1)+']');
      if(target.length){
        $('main').animate({
        scrollTop:target.offset().top-76
        },1000);
      return false;
      }
    }
  });
})(jQuery);
