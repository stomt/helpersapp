var city    = null,
    cities  = null,
    baseUrl = '//'+document.location.hostname+':'+location.port+'/cities',
    tc      = 'tap', // tap or click?
    homeUsed = false
    ;

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
$(document)
    .bind('pageinit',function(){

        $.ajaxSetup();

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

        // Change to startpage and prevent ajax-call by setting homeUsed=true
        $('a[data-icon="home"]').on(tc,function(){
            homeUsed=true;
            $.mobile.changePage($('#home'));
        });

        // Startpage
        $('#home')
            .on('pagebeforeshow',function(event){
                if(homeUsed == false){                                          // Page impression by home-button or adress-bar?
                    $.ajax({                                                    // Get list if available locations
                        url: baseUrl,
                        context: this,
                        dataType: 'json'
                    })
                        .success(function(data) {
                            if (data.success) {

                                cities = data.cities;                           // Set available locations

                                var hash = window.location.hash,                // Get Hash-URI
                                    hCity = hash.substr(1,hash.length),         // Remove the #
                                    index = false;
                                if(hCity!=''){
                                    $.each( cities, function( key, value ) {    // Validate URIs location and change to location if possible
                                        if(value == hCity){
                                            city = key;
                                            $.mobile.changePage($('#offerHelp'));
                                        }
                                    });
                                }else{
                                    if(city == null){
                                        city = data.city_id;
                                    }

                                    setHeader(city);
                                    $.mobile.changePage($('#offerHelp'));
                                }
                            }
                        });
                }else{
                    // The home-button has been used, reset to false to prevent the ajax-call above
                    homeUsed = false;
                }

            })

            // POST City
            .on('pageshow',function(){
                $('.chooseCity')
                    .on('change',function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();

                        city = $(this).val();
                        setHeader(city);
                        $.ajax({
                            type: 'post',
                            url: baseUrl,
                            context: this,
                            data: {
                                "city_id" : city
                            }
                        }).success(function(data) {
                                if (data.success) {
                                    city = data.city;
                                    cities = data.cities;
                                    $.mobile.changePage($('#offerHelp'));
                                }
                            });
                    });
            });


        // Create Insertion
        $('#searchHelp')

            // GET City
            .on('pagebeforeshow',function(event){
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
                                $.mobile.changePage($('#home'));
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
            })

            // POST Insertion
            .on('pageshow',function(){
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
                                $.mobile.changePage($('#offerHelp'));
                            } else {
                                alert("Something failed.");
                            }
                            // }
                        });
                    // }
                })
            });


        // My Page
        $('#helpdata')

            // GET City
            .on('pagebeforeshow',function(event){
                $('.city').html("Your overview");


                $.ajax({
                    url: baseUrl+"/myhelp",
                    context: this
                }).success(function(data) {
                        if (data.success) {
                            $("#helpDataReq").html(data.html).trigger('create');
                        }
                    });
            })



            .on('pageshow',function(){
                $(this)
                    // JOIN/LEAVE Insertion
                    .on(tc,'.help',function(e){
                        e.preventDefault()
                        e.stopPropagation()
                        e.stopImmediatePropagation();

                        // set loadingstate
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
            });


        // Index Insertion
        $('#offerHelp')

            // GET Insertions (and GET City)
            .on( 'pagebeforeshow',function(event){
                if(city==null) window.location = '/';

                setHeader(city);
                // load content immediately
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

            })

            // Interaction with Insertion
            .on('pageshow',function(){
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

                        // set loadingstate
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
            });

    });

