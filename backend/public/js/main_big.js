var city    = null,
    cities  = ['','Bhaktapur','Dhading','Dolakha','Gorkha','Kathmandu','Kavre','Lalitpur','Lamjung','Ramechhap','Rasuwa'],
    baseUrl = '//'+document.location.hostname+':'+location.port+'/cities',
    tc      = 'tap'; // tap or click?

function stopBubble(e){
  e.preventDefault()
  e.stopPropagation()
  e.stopImmediatePropagation();
}

function IsValidAmount(value){
    if(value.length==0)
        return false;

    var intValue=parseInt(value);
    if(intValue==Number.NaN)
        return false;

    if(intValue<=0)
        return false;
    return true;
}

function setHeader(city) {
  if (cities && city) $('.city').html(cities[city]);
}
function createCookie(name, value, days) {
  var expires;
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 86400000)); // 24 * 60 * 60 * 1000
    expires = "; expires=" + date.toGMTString();
  } else {
    expires = "";
  }
  document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
  var nameEQ = encodeURIComponent(name) + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name, "", -1);
}
function setContent(content) {
  $("#helpRequests").html(content).trigger('create');
}
function getCity(){
  return city || readCookie('city');
}
function setCity(city_id){
  city = city_id;
  createCookie('city', city_id, 60);
}
$(document)
  .on("pagebeforecreate", function (e, ui) {

  var page = $.mobile.pageContainer.pagecontainer("getActivePage")[0].id;

  if(page == 'searchHelp'){
    if(city == null){
      $.ajax({
        url: baseUrl,
        context: this
      }).success(function(data) {
        if (data.success) {
          city = data.city_id;
          setHeader(city);
        } else {
          alert("shit 1")
          $.mobile.pageContainer.pagecontainer('change','#home');
        }
      });
    } else {
      setHeader(city);
    }

    var date = new Date();
    var offset = new Date().getTimezoneOffset();
    // Set current date
    var day = date.getUTCDay();
    var days = new Array();
    days[0] = "Sunday";
    days[1] = "Monday";
    days[2] = "Tuesday";
    days[3] = "Wednesday";
    days[4] = "Thursday";
    days[5] = "Friday";
    days[6] = "Saturday";

    for (var i = 0; i <= days.length; i++) {
      if (i == 0) {
        $('#choice-day-'+i).html('Today (' + days[(day + i) % days.length] + ')');
      } else if (i == 1) {
        $('#choice-day-'+i).html('Tomorrow (' + days[(day + i) % days.length] + ')');
      } else {
        $('#choice-day-'+i).html(days[(day + i) % days.length]);
      }
    };
    $('#select-choice-day').selectmenu("refresh", true);

    // Set current time
    var hour = date.getUTCHours() - offset / 60;
    $('#choice-hour-' + hour).attr('selected', true);
    $('#select-choice-hours').selectmenu("refresh", true);
  }
})



.on("pagecontainertransition", function (e, ui) {
  var page = $.mobile.pageContainer.pagecontainer("getActivePage")[0].id;

    if(page == 'home'){
      $(document)
        .on('change','.chooseCity', function(e){
          stopBubble(e);
          setCity($(this).val());
          $.ajax({
            type: 'post',
            url: baseUrl,
            context: this,
            data: {
              "city_id" : city
            }
          }).success(function(data) {
            if (data.success) {
              createCookie('city', city, 60);
              $.mobile.changePage('#offerHelp');
            }
          });


        });
    }

  if(page == 'searchHelp'){
    $('#createHelpRequest').on(tc,function(e){
      stopBubble(e);

      // Validate Input
      if(IsValidAmount($('#helperRequested').val()) == false){
        alert("How many helpers are nedded?");
        return false;
      }
      if($.trim($('#address').val()) == ''){
        alert("Please enter an address");
        return false;
      }

      // var recieved = false;
      // var started = false;
      // if(started == false){
      //     started = true;
      $.ajax({
        type: "post",
        url: baseUrl+"/"+city+"/insertions",
        context: this,
        data: $(this).parent().serialize()
      }).success(function(data) {
        // if (recieved == false) {
        //     recieved = true;
        if (data.success){
          $.mobile.pageContainer.pagecontainer('change','#offerHelp');
        } else {
          alert("Something failed.");
        }
        // }
      });
      // }
    })
  }

  if(page == 'helpdata'){
    $('.city').html("Your overview");

    $.ajax({
      url: baseUrl+"/myhelp",
      context: this
    }).success(function(data) {
      if (data.success) {
        $("#helpDataReq").html(data.html).trigger('create');
      }
    });

    $(this)
      // JOIN/LEAVE Insertion
      .on(tc,'.help',function(e){
        stopBubble(e);

        // set changeing state
        $(this)
          .html('<span class="ui-btn-inner"><span class="ui-btn-text">Please wait...</span></span>')
          .removeAttr('data-role');

        var amount = $(this).data('amount');

        $.ajax({
          type: "post",
          url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid')+"/help",
          context: this,
          data: {
            "amount" : amount
          },
          dataType: 'json'
        }).success(function(data) {
          if (data.success) {
            $("#helpDataReq").html(data.html).trigger('create');
          }
        });
      })


      // STORE amountHelper in submitbutton
      .on('change','.amountHelper',function(e){
        stopBubble(e);

        var amount = parseInt($('select.amountHelper option:selected').val());
        var button = $(this).parent().parent().parent().find('.help');

        if (button.data('help') == 'increaseHelp') {
          button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'are coming!' : 'come!') + '</span></span>')
            .data('amount', amount);
        } else {
          button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'Revoke '+amount : 'Revoke!') + '</span></span>')
            .data('amount', -amount);
        }
      })

      // DELETE Insertion
      .on(tc,'.delete',function(e){
        stopBubble(e);

        $.ajax({
          type: 'delete',
          url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid'),
          context: this,
          dataType: 'json'
        }).success(function(data) {
          if (data.success) {
            $("#helpDataReq").html(data.html).trigger('create');
          } else {
            alert("Deleting the help-request failed.")
          }
        });
      })
  }


  if(page == 'offerHelp'){
    city = getCity();
    setHeader(city);
    // change content immediately
    $.ajax({
      url: baseUrl+"/" + city + "/insertions",
      context: this
    }).done(function(data) {
      if (data.success) {
        setContent(data.html);
      } else {
        //alert('ERROR: TODO')
      }
    });

    $(this)

      // DELETE Insertion
      .on(tc,'.delete',function(e){
        stopBubble(e);

        $.ajax({
          type: 'delete',
          url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid'),
          context: this,
          dataType: 'json'
        }).success(function(data) {
          if (data.success) {
            setContent(data.html);
          } else {
            alert("Deleting the help-request failed.")
          }
        });
      })

      // JOIN/LEAVE Insertion
      .on(tc,'.help',function(e){
        stopBubble(e);

        // set changeingstate
        $(this)
          .html('<span class="ui-btn-inner"><span class="ui-btn-text">Please wait...</span></span>')
          .removeAttr('data-role');

        var amount = $(this).data('amount');

        $.ajax({
          type: "post",
          url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid')+"/help",
          context: this,
          data: {
            "amount" : amount
          },
          dataType: 'json'
        }).success(function(data) {
          if (data.success) {
            setContent(data.html);
          }
        });
      })


      // STORE amountHelper in submitbutton
      .on('change','.amountHelper',function(e){
        stopBubble(e);

        var amount = parseInt($('select.amountHelper option:selected').val());
        var button = $(this).parent().parent().parent().find('.help');

        if (button.data('help') == 'increaseHelp') {
          button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'will come!' : 'will come!') + '</span></span>')
            .data('amount', amount);
        } else {
          button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'Revoke '+amount : 'Revoke!') + '</span></span>')
            .data('amount', -amount);
        }
      })
  }
})

.bind('pagecreate',function(){
      // change to startpage and prevent ajax-call by setting homeUsed=true
    $(document).on(tc, 'a[data-icon="home"]', function(e){
      stopBubble(e);
      $.mobile.pageContainer.pagecontainer('change', '#home');
      $("#helpRequests").html('');
    });
  })
.one("mobileinit", function () {
$.ajaxSetup();
$.mobile.linkBindingEnabled = true;
$.mobile.ajaxEnabled = true;
$.fx.off = true;
});;

