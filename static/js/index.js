$(function(){
  var swiper = new Swiper('.swiper-container', {
    pagination: {
      el: '.swiper-pagination',
    },
    grabCursor: true
  });
  swipeable(swiper);
  learn(swiper);
})

function swipeable(swiper){
  
  $(".swipe-scroll").on('click', function(e) {
    e.preventDefault();
    var scrollto = $(this).attr('href');
    var swipeindex = $(this).attr('data-index');

    $('html, body').animate({ scrollTop: $(scrollto).offset().top }, 400);
    swiper.slideTo(swipeindex, 600, false);

  });
}

function learn(swiper){
  var urlParams = new URLSearchParams(window.location.search); //get all parameters
  var foo = urlParams.get('learn');
  if(foo !== null){
    setTimeout(function(){
      $('html, body').animate({ scrollTop: $("#features").offset().top }, 400);
      swiper.slideTo(foo, 600, false);
    }, 1000)
    var clean_uri = location.protocol + "//" + location.host + location.pathname;
    window.history.replaceState({}, document.title, clean_uri);
  }
}