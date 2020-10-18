$(function(){
  swipeable();
})

function swipeable(){
  var swiper = new Swiper('.swiper-container', {
    pagination: {
      el: '.swiper-pagination',
    },
    grabCursor: true
  });
  $(".swipe-scroll").on('click', function(e) {
    e.preventDefault();
    var scrollto = $(this).attr('href');
    var swipeindex = $(this).attr('data-index');

    $('html, body').animate({ scrollTop: $(scrollto).offset().top }, 400);
    swiper.slideTo(swipeindex, 600, false);

  });
}