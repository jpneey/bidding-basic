$(function(){
    $('.scrollspy').scrollSpy();
    $('.pushpin').pushpin({
      top: 0,
      offset: 0,
    });
    $('.fixed-action-btn').floatingActionButton();
})


function timer(time){
  
  var countDownDate = new Date(time).getTime();
  
  var x = setInterval(function() {

    var now = new Date().getTime();
    var distance = countDownDate - now;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    $('#days').text(days);
    $('#hours').text(hours);
    $('#minutes').text(minutes);
    $('#seconds').text(seconds);
    
    if (distance < 0) {
      clearInterval(x);
      $('#days').text(00);
      $('#hours').text(00);
      $('#minutes').text(00);
      $('#seconds').text(00);
      updateExpiredBiddings(true);
    }

  }, 1000);
}