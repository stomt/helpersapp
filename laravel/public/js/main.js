var city    = null,
    cities  = null,
    baseUrl = '//'+document.location.hostname+':'+location.port+'/cities',
    tc      = 'tap' // tap or click?
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
                $('.city').html("Übersicht");
            }
        }

        function setContent(content) {
            $("#helpRequests").html(content).trigger('create');
        }


        // Startpage
        $('#home')

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
                            $.mobile.changePage($('#offerHelp'));
                        }
                    });
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
                            setHeader(city);
                        } else {
                            $.mobile.changePage($('#home'));
                        }
                    });
                } else {
                    setHeader(city);
                }
            })

            // POST Insertion
            .on('pageshow',function(){
                $('#createHelpRequest').on(tc,function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    // Validate Input
                    if(IsValidAmount($('#helperRequested').val()) == false){
                        alert("Bitte gib eine Zahl ein!");
                        return false;
                    }
                    if($('#amountHelper').val() == '' || $('#address').val() == ''){
                        alert("Adresse und Anzahl Helfer sind Pflicht!");
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
                                    alert("Ein Fehler ist aufgetreten");
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
                $('.city').html("Übersicht");


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
                            .html('<span class="ui-btn-inner"><span class="ui-btn-text">Bitte warten...</span></span>')
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
                            button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'kommen!' : 'komme!') + '</span></span>')
                                .data('amount', amount);
                        } else {
                            button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'wieder absagen!' : 'sage ab!') + '</span></span>')
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
                                alert("Fehler beim Löschen der Hilfe-Anfrage.")
                            }
                        });
                    })
            });


        // Index Insertion
        $('#offerHelp')

            // GET Insertions (and GET City) 
            .on( 'pagebeforeshow',function(event){
                if (city == null) {

                    // request city_id first
                    $.ajax({
                        url: baseUrl,
                        context: this
                    }).success(function(data) {
                        if (data.success) {
                            city = data.city_id;
                            cities = data.cities;
                            setHeader(city);

                            // load content after recieving city_id
                            $.ajax({
                                url: baseUrl+"/" + city + "/insertions",
                                context: this
                            }).done(function(data) {
                                if (data.success) {
                                    setContent(data.html);
                                } else {
                                    alert('ERROR: TODO')
                                }
                            }); 
                        } else {
                            $.mobile.changePage($('#home'));
                        }
                    });

                } else {
                    setHeader(city);
                    // load content imidiatly
                    $.ajax({
                        url: baseUrl+"/" + city + "/insertions",
                        context: this
                    }).done(function(data) {
                        if (data.success) {
                            setContent(data.html);
                        } else {
                            alert('ERROR: TODO')
                        }
                    }); 
                }
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
                                alert("Fehler beim Löschen der Hilfe-Anfrage.")
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
                            .html('<span class="ui-btn-inner"><span class="ui-btn-text">Bitte warten...</span></span>')
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
                            button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'kommen!' : 'komme!') + '</span></span>')
                                .data('amount', amount);
                        } else {
                            button.html('<span class="ui-btn-inner"><span class="ui-btn-text">' + (amount > 1 ? 'wieder absagen!' : 'sage ab!') + '</span></span>')
                                .data('amount', -amount);
                        }
                    })
            });
    
    });