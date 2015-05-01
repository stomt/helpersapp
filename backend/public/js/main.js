var city    = null,
    cities  = null,
    baseUrl = '//'+document.location.hostname+':'+location.port+'/cities',
    tc      = 'tap', // tap or click?
    homeUsed = false
    ;
function getUrlParam(sParam)
{
  var sPageURL = window.location.search.substring(1);
  var sURLVariables = sPageURL.split('&');
  for (var i = 0; i < sURLVariables.length; i++)
  {
    var sParameterName = sURLVariables[i].split('=');
    if (sParameterName[0] == sParam)
    {
      return sParameterName[1];
    }
  }
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
  if (cities && city) {
    $('.city').html(cities[city]);
  } else {
    $('.city').html("Overview");
  }
}

function setContent(content) {
  $("#helpRequests").html(content).trigger('create');
}

$(document)
  .on("pagebeforecreate", function (e, ui) {

  var page = $.mobile.pageContainer.pagecontainer("getActivePage")[0].id;

  if(page == 'home'){
    if(homeUsed == false){                                        // Page impression by home-button or adress-bar?
      $.ajax({                                                    // Get list if available locations
        url: baseUrl, context: this, dataType: 'json'
      })
      .success(function(data) {
        if (data.success) {
          cities = data.cities;                           // Set available locations

          var hash = window.location.hash,                // Get Hash-URI
            hCity = hash.substr(1,hash.length),         // Remove the #
            index = false;

          if(hCity!=undefined && hCity !=''){
            $.each( cities, function( key, value ) {    // Validate URIs location and change to location if possible
              if(value == hCity){
                city = key;
                $.mobile.pageContainer.pagecontainer('change','#offerHelp');
              }
            });
          }else{
            if(city == null){
              city = data.city_id;
            }

            setHeader(city);
            $.mobile.pageContainer.pagecontainer('change','#offerHelp');
          }
        }
      });
    }else{
      // The home-button has been used, reset to false to prevent the ajax-call above
      homeUsed = false;
    }
  }

  if(page == 'searchHelp'){
    if(city == null){
      $.ajax({
        url: baseUrl,
        context: this
      }).success(function(data) {
        if (data.success) {
          city = data.city_id;
          cities = data.cities;
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
  }

  if(page == 'offerHelp'){

    if(city==null) window.location = '/';
console.log(city)
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
  }

})

.on("pagecontainertransition", function (e, ui) {
  var page = $.mobile.pageContainer.pagecontainer("getActivePage")[0].id;

  if (page == 'home') {
    $('.chooseCity')
      .off('change')
      .on('change',function(e){
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        city = $(this).val();

        $.ajax({
          type: 'post',
          url: baseUrl,
          context: this,
          data: {
            "city_id" : city
          }
        }).success(function(data) {
          if (data.success) {
            $.mobile.pageContainer.pagecontainer('load','#offerHelp');
          }
        });
      });
  }

  if(page == 'searchHelp'){
    $('#createHelpRequest').on(tc,function(e){
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

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
          $.mobile.pageContainer.pagecontainer('load','#offerHelp');
        } else {
          alert("Something failed.");
        }
        // }
      });
      // }
    })
  }

  if(page == 'helpdata'){
    $(this)
      // JOIN/LEAVE Insertion
      .on(tc,'.help',function(e){
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation();

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
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation();

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
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

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
    $(this)

      // DELETE Insertion
      .on(tc,'.delete',function(e){
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

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
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation();

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
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation();

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
      $.ajaxSetup();
      $.mobile.linkBindingEnabled = true;
      $.mobile.ajaxEnabled = true;

      // change to startpage and prevent ajax-call by setting homeUsed=true
      $('a[data-icon="home"]').on(tc, function(){
          homeUsed=true;
        $.mobile.pageContainer.pagecontainer('load', '#home');
      });

  });

