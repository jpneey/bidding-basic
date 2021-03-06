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
  seachDropdown();
  
  paginate();
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
      console.log(data);
      viewOfferModal(data);
    }
  })

}

function viewOfferModal(data){
  var parsedData = JSON.parse(data);
  var image = '<br><img src="'+ root + 'static/asset/bidding/' + parsedData.img+'" class="image-pop" onError="this.onerror = \'\';this.style.display=\'none\';" />' + '<img src="'+ root + 'static/asset/bidding/' + parsedData.img_two+'" class="image-pop" onError="this.onerror = \'\';this.style.display=\'none\';" />';
  image += '<img src="'+ root + 'static/asset/bidding/' + parsedData.img_three+'" class="image-pop" onError="this.onerror = \'\';this.style.display=\'none\';" />';
  var link = '<br><br>' + ' <a href="#!" data-view="'+parsedData.view+'"class="btn-small view-poster vp-s green lighten-1">View Supplier</a>' + ' <a href="#!" data-view="'+parsedData.owner+'"class="btn-small vp-c view-poster green lighten-1">View Client</a>'
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
        window.location.href = root + 'user' + '/' + data.selector + '/';
        return
      }
    })
  })
}

function seachDropdown(){
  $('#search-category').on('change', function(){
    filterSearch(0);
  })
  $('#search-location').on('change', function(){
    filterSearch(1);
  })

  $('.clear-filter').on('click', function(){
    $('#search-category, #search-location').val(0);
    $(".categ-filter, .loc-filter").removeClass("hidden");
    paginate();
  })

}
function filterSearch(t){
  try {
    $('.feed-wrap-main').data('paginate').kill();
  } catch(err) {
    console.log(err);
  }
  var cat = $.trim($("#search-category option:selected").text());
  var loc = $.trim($("#search-location option:selected").text());
  /* categ-filter loc-filter */
  if(t == 0) {
    $(".categ-filter").removeClass("hidden");
    if(cat != "All Categories"){
      $(".categ-filter").not("[data-category='"+cat+"']").toggleClass("hidden", function(){
        $(".categ-filter[data-category='"+cat+"']").removeClass("hidden");
      });
    } else {
      $(".categ-filter").removeClass("hidden");
    }
    
    if(loc != "All Locations"){
      $(".loc-filter").addClass("hidden");
      if(cat != "All Categories"){
        $(".loc-filter[data-location='"+loc+"'][data-category='"+cat+"']").removeClass("hidden");
      } else {
        $(".loc-filter[data-location='"+loc+"']").removeClass("hidden");
      }
    }
    
  }
  if(t == 1) {
    $(".loc-filter").removeClass("hidden");
    if(loc != "All Locations"){
      $(".loc-filter").not("[data-location='"+loc+"']").toggleClass("hidden", function(){
        $(".loc-filter[data-location='"+loc+"']").removeClass("hidden");
      });
    } else {
      $(".loc-filter").removeClass("hidden");
    }
    if(cat != "All Categories"){
      $(".categ-filter").addClass("hidden");
      if(loc != "All Locations"){
        $(".categ-filter[data-location='"+loc+"'][data-category='"+cat+"']").removeClass("hidden");
      } else {
        $(".categ-filter[data-category='"+cat+"']").removeClass("hidden");
      }
    }
  }
}

function paginate(){
  $('.feed-wrap-main').paginate({
    perPage: 12,      
    autoScroll: true,           
    scope: 'a',         
    paginatePosition: ['bottom'],     
    containerTag: 'div style="padding: 15px"',
    paginationTag: 'ul',
    itemTag: 'li',
    linkTag: 'a',
    useHashLocation: false,           
    onPageClick: function() {}   
  });
}