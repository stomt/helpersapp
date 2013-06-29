var city    = null,
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

        $('.amountHelper').change(function(){
            if($("select option:selected").val()>1){
                $(this).next().html('kommen!')
            }else{
                $(this).next().html('komme!')
            }
        })

        // Startpage - check if city already chosen
        $( '#home' )
            .on( 'pagebeforeshow',function(event){
                if(city==null){
                    $.ajax({
                        url: baseUrl,
                        context: this
                    }).done(function(data) {
                        if (data.success) {
                            city = data.city_id;
                            $('.city').html(city + ' NAME');
                            $.mobile.changePage($('#offerHelp'));
                        }
                    });
                }
            })
            .on('pageshow',function(){
                $('.chooseCity')
                .on('change',function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    city = $(this).val();
                    $('.city').html(city);
                    $.ajax({
                        type: 'post',
                        url: baseUrl,
                        context: this,
                        data: {
                            "city_id" : city
                        }
                    }).success(function(data) {
                            $.mobile.changePage($('#offerHelp'));
                        });
                });
            });

        $('#searchHelp')

            // GET City
            .on( 'pagebeforeshow',function(event){
                if(city==null){
                    $.ajax({
                        url: baseUrl,
                        context: this
                    }).done(function(data) {
                        if(data != 'false' && data != ''){
                            city = data;
                            $('.city').html(data);
                        }else{
                            $.mobile.changePage($('#home'));
                        }
                    });
                }
            })

            // POST Insertion
            .on('pageshow',function(){
                $('#createHelpRequest').on(tc,function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    if(IsValidAmount($('#helperRequested').val()) == false){
                        alert("Bitte gib eine Zahl ein!");
                        return false;
                    }
                    if($('#amountHelper').val()=='' || $('#address').val()=='' ){
                        alert("Adresse und Anzahl Helfer sind Pflicht!");
                        return false;
                    }
                    var run = false, run2 = false;
                    if(run2==false){
                        run2=true;
                        $.ajax({
                            type: "post",
                            url: baseUrl+"/"+city+"/insertions",
                            context: this,
                            data: $(this).parent().serialize()
                        }).done(function(data) {

                            if(run == false) {
                                run = true;
                                if(data.success){
                                    $.mobile.changePage($('#offerHelp'));
                                } else {
                                    alert("Ein Fehler ist aufgetreten");
                                }
                            }
                        });
                    }
                })

            });

        $('#helpdata')

            // GET City 2 (löschen?)
            .on( 'pagebeforeshow',function(e){
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                if(city==null){
                    $.ajax({
                        url: baseUrl,
                        context: this
                    }).done(function(data) {
                        if(data != 'false' && data != ''){
                            city = data;
                            $('.city').html(data);
                        }else{
                            $.mobile.changePage($('#home'));
                        }
                    });
                }

                $.ajax({
                    url: baseUrl+"c=Help&m=getMyHelpRequests",
                    context: this
                })
                    .done(function(d) {$("#helpDataReq").html(d).trigger('create');});
            }) 

            .on('pageshow',function(){
                $(this)
                    .on(tc,'.help',function(e){
                        $(this).parent().css('display','none')
                        var run = false;
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();

                        $.ajax({
                            url: baseUrl+"c=Help&m=decreaseHelp",
                            context: this,
                            data: {
                                'iid' : $(this).data('iid')
                            },
                            dataType: 'json'
                        });
                    })
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
                                if(data.success){
                                    $("#helpRequests").html(data.html).trigger('create');
                                }else{
                                    alert("Fehler beim Löschen der Hilfe-Anfrage.")
                                }
                            })
                    })
            });

        $( '#offerHelp' )
            .on( 'pagebeforeshow',function(event){
                if(city==null){
                    $.ajax({
                        url: baseUrl,
                        context: this
                    }).done(function(data) {
                        if(data != 'false' && data != ''){
                            city = data;
                            $('.city').html(data);
                        }else{
                            $.mobile.changePage($('#home'));
                        }
                    });
                }

                $.ajax({
                    url: baseUrl+"/" + city + "/insertions",
                    context: this
                }).done(function(data) {
                    if (data.success) {
                        $("#helpRequests").html(data.html).trigger('create');
                    } else {
                        alert('ERROR: TODO')
                    }
                });

                // Get data

            })
            .on('pageshow',function(){
                $(this)
                    .on(tc,'.delete',function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();

                        $.ajax({
                            type: 'delete',
                            url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid'),
                            context: this,
                            dataType: 'json'
                        })
                            .success(function(data) {
                                if(data=="false"){
                                    alert("Fehler beim Löschen der Hilfe-Anfrage.")
                                }else{
                                    $("#helpRequests").html(data.html).trigger('create');
                                }
                            })
                    })
                    .on(tc,'.help',function(e){
                        $(this)
                            .html('<span class="ui-btn-inner"><span class="ui-btn-text">Bitte warten...</span></span>')
                            .removeAttr('data-role')
                            ;
                        var m   = $(this).data('help'),
                            run = false;

                        e.preventDefault()
                        e.stopPropagation()
                        e.stopImmediatePropagation();
                        
                        var amount = 1;
                        if (m == 'increaseHelp') {
                            amount = 1;
                        } else {
                            amount = -1;
                        }
                        $.ajax({
                            type: "post",
                            url: baseUrl+"/"+city+"/insertions/"+$(this).data('iid')+"/help",
                            context: this,
                            data: {
                                "amount" : amount //$(this).data('amountHelper')
                            },
                            dataType: 'json'
                        })
                            .success(function(data) {
                                if (data.success == true && run == false){
                                    $("#helpRequests").html(data.html).trigger('create');
                                    run = true;
                                }

                            });

                    }).on('change','.amountHelper',function(e){
                        e.preventDefault()
                        e.stopPropagation()
                        e.stopImmediatePropagation();
                        var v = $('select.amountHelper option:selected').val(),
                        h=$(this).parent().parent().parent().find('.help');
                        if(h.data('help')=='increaseHelp'){
                            h.html('<span class="ui-btn-inner"><span class="ui-btn-text">'+((parseInt(v)>1)?'kommen!':'komme!')+'</span></span>')
                            .data('amountHelper',v)
                            .button('refresh')
                        }else{
                            h.html('<span class="ui-btn-inner"><span class="ui-btn-text">'+((parseInt(v)>1)?'wieder absagen!':'sage ab!')+'</span></span>')
                                .data('amountHelper',v)
                                .button('refresh')
                        }
                    })

            });
    });