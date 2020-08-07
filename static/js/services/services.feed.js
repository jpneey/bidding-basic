$(function(){
    $('.scrollspy').scrollSpy();
    $('.pushpin').pushpin({
      top: 0,
      offset: 0,
    });
    $('.fixed-action-btn').floatingActionButton();
    starRates();
})


$(window).on('resize scroll', function() {
  loadNextBidding();
});



function starRates() {
  $('.ratings').each(function() {
    var child = (5 - $(this).children().length);
    $(this).append('<i class="material-icons orange-text">star_outline</i>'.repeat(child));
  });
}

function loadNextBidding(){
  if(!$('#bidFeedNext').length){ return }
  if($('#bidFeedNext').isInViewport()) {
    $('#load-wrap').fadeIn(500);
    $.ajax({
      url: root + 'controller/controller.bidding.more.php?token='+$('#bidFeedNext').data('id')+"&base="+$('#bidFeedNext').data('base'),
      type: 'GET',
      processData: false,
      contentType: false,
      
      success: function(data) {
        $('#load-wrap').fadeOut(500);
        $('#bidding-feed').append(data);
        $("time.timeago").timeago();
        starRates();
      }
    })

    $('#bidFeedNext').remove();
  }
}

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