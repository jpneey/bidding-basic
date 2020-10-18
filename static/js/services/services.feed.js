$(function(){
  $('.scrollspy').scrollSpy();
  $('.pushpin').pushpin({
    top: 0,
    offset: 0,
  });
  $('.fixed-action-btn').floatingActionButton();
  starRates();
  offerModalTrigger();
  prepareOffer();
  viewModal();
})


function starRates() {
  $('.ratings').each(function() {
    var child = (5 - $(this).children().length);
    $(this).append('<i class="material-icons orange-text">star_outline</i>'.repeat(child));
  });
}

/* addon func for IOS that does not implement (ISO 8601) data format */
function cDate(date) {
  var arr = date.split(/[- :]/);
  date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
  return date;
}

function timer(time){
  
  var countDownDate = new Date(cDate(time)).getTime();
  
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

function offerModalTrigger(){
  $('.offer-modal-trigger').on('click', function(){
    var token = $(this).data('offer');
    $('#open-offer').attr('data-offer', token);
  })
}

function prepareOffer(){
  $('#open-offer').on('click', function(){
    var token = $(this).data('offer');
    $("body, html").css({opacity: "0.5",cursor: "wait"});
    $('#load-wrap').fadeIn(500);
    window.onbeforeunload = function() { return "Reloading may not save your changes. Are you sure you want to leave the page?";};
    $.ajax({
      url: root + 'controller/controller.offer.php?action=open&selector='+token,
      type: 'GET',
      processData: false,
      contentType: false,
      success: function(data) {
        $('#load-wrap').fadeOut(500);
        window.onbeforeunload = null;
        $("body, html").css({opacity: "1",cursor: "auto"});
        var parsedData = JSON.parse(data);
        if(parsedData.code == '0'){
          var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';
          M.toast({
            html: parsedData.message + action,
            classes: "red white-text"
          });  
          return
        }
        window.location.search = '?view=' + parsedData.id;
        return
      }
    })
  })
}

function viewModal(){
  $('.view-modal').on('click', function(){
    var token = $(this).data('offer');
    prepareModal(token);
  })
}

function prepareModal(token){
  /* $('#load-wrap').fadeIn(100); */
  $.ajax({
    url: root + 'controller/controller.offer.php?action=view&selector='+token,
    type: 'GET',
    processData: false,
    contentType: false,
    success: function(data) {
      /* $('#load-wrap').fadeOut(100); */
      var parsedData = JSON.parse(data);
      if(parsedData.code == '0'){
        var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';
        M.toast({
          html: parsedData.message + action,
          classes: "red white-text"
        });  
        return
      }
      viewOfferModal(data);
    }
  })

}

function viewOfferModal(data){
  var parsedData = JSON.parse(data);
  var image = '<br><img src="'+ root + 'static/asset/bidding/' + parsedData.img+'" class="materialboxed" onError="this.onerror = \'\';this.style.display=\'none\';" />' + '<img src="'+ root + 'static/asset/bidding/' + parsedData.img_two+'" class="materialboxed" onError="this.onerror = \'\';this.style.display=\'none\';" />';
  image += '<img src="'+ root + 'static/asset/bidding/' + parsedData.img_three+'" class="materialboxed" onError="this.onerror = \'\';this.style.display=\'none\';" />';
  var link = '<br><br>' + ' <a href="#!" data-view="'+parsedData.view+'"class="btn-small view-poster green lighten-1">profile</a>';
  $('#view-offer-content').html(parsedData.offer + link + image);
  $(".qty").text($('.item').data('unit'));
  $('#view-offer-modal').modal({
    inDuration : '500',
    outDuration : '500',
    preventScrolling: true
  });
  $('.materialboxed').materialbox();
  $('#view-offer-modal').modal('open');
  
  viewPoster();
}

function viewPoster() {
  $('.view-poster').on('click', function(){
    var token = $(this).data('view');

    $.ajax({
      url: root + 'controller/controller.user.php?action=view&selector='+token,
      type: 'GET',
      processData: false,
      contentType: false,
      success: function(data){
        var data = JSON.parse(data);
        if(data.code == '0'){
          M.toast({ html: data.message, classes: "red white-text"});  
          return
        }
        window.location.href = root + data.path + '/' + data.selector + '/';
        return
      }
    })
  })
}