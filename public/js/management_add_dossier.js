

$(document).ready(function(){

    var _url = $('#api').find('#index').val();

    var _csrf_token = $('#api').find('input[name="_token"]').val();

    var _dataRequest = {
        _token : _csrf_token
    };

    var displayElementSecteures = function() {

        var _delay = 0;
        $('#list_elements_secteur > .container-card').each(function( ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            _delay = _delay + 100;
        });

    };

    var displayElementGouvernorats = function() {

        var _delay = 0;
        $('#list_elements_gouveronrat > .container-card').each(function( ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            _delay = _delay + 100;
        });

    };

    var displayElementDelegations = function(_id_gouvernorat) {

        var _delay = 0;
        $('#list_elements_delegations_' + _id_gouvernorat + ' > .container-card').each(function( ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            _delay = _delay + 100;
        });

    };

    function creatDossier(url, data_elemen) {

        $.ajax({
            type: 'POST',
            url: url,
            data: data_elemen,
            dataType: 'json',
            success: function(data) {

                if(data.status == 'success') {
                    swal({
                        title: data.msg,
                        text: data.msg_text,
                        type: "success",
                        html: true,
                        timer: 3000,
                        showConfirmButton: false
                    },
                    function(){

                        // redirection detail file
                        window.location.href = $('#api').find('#store').val() + '/' + data.id;
                    });

                    // redirection ver elintihakat
                } else {
                    //console.log(data);
                    swal({
                        title: data.msg,
                        text: data.msg_text,
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });

                    $('#list_elements').show( 'fade', {}, 'slow');
                }
            },
            error: function(data){
                //console.log(data);
                swal({
                    title: data.responseText,
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#list_elements').show( 'fade', {}, 'slow');
            }
        });

    }

    var loadElements = function(elements) {

        $('#list_elements').show('fade', {}, 'fast', function() {

            var count = elements.length;

            $.each(elements, function (key, data) {
                var _container = $('#template_container').html();

                $.each(data, function (index, data) {
                    if(data== null) {
                        _container = _container.replace(new RegExp("{"+index+"}", 'g'), '');
                    } else {
                        _container = _container.replace(new RegExp("{"+index+"}", 'g'), data);
                    }

                });

                $('#list_elements').append(_container);

                if (!--count) displayElement();

            });

        });

    };

    var displayElement = function() {

        var _delay = 800;
        $('#list_elements > .container-card').each(function( ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            $(this).find('select').each(function( ) {
                var _valDefault = $(this).attr('data-reset');
                $(this).find('option[value='+_valDefault+']').attr('selected','selected');
            });

            _delay = _delay + 100;
        });

        $('.container-action-search').show('fade', {}, 'fast');

        $('[data-toggle="tooltip"]').tooltip();

    };

    function getList(url, data) {

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'json',
            success: function(data) {
                // success logic
                //console.log(data);
                $('.loading_data').hide('fade', {}, 500, function(){
                    $('#header_index').show( 'fade', {}, 'slow', function(){
                        //
                    });
                });




                if(data.status == 'success') {
                    $('.container-tools').show('fade', {}, 'slow', function() {

                        if( data.elements.length > 0 ) {
                            loadElements(data.elements);

                        } else {
                            // display message aucun elements
                            $('.container-empty-element').show('fade', {}, 'slow', function() {

                            });
                        }

                    });



                } else {
                    //diplay type error
                    //console.log(data);
                }

            },
            error: function(data){
                console.log(data);
            }
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    displayElementSecteures();

    $(document).on('click', '.set_secteur', function(){

        var _idSecteur = $(this).attr( 'data-ajax' );
        var _nomSecteur = $(this).attr( 'data-field-name');
        $('#secteur_label_text').text(_nomSecteur);
        $('#indicat_secteur').text(_nomSecteur);


        $('#secteur_id').val(_idSecteur);

        //display gouvernorat
        $('#list_elements_secteur').hide( 'fade', {}, 'fast', function(){

            $('#header_index').hide( 'fade', {}, 'fast', function(){
                $(this).find('#title_choizir_secteur').hide();
                $(this).find('#title_choizir_gouvernorat').show();

                $(this).show( 'fade', {}, 'slow', function(){
                    displayElementGouvernorats();
                });
            });

        });




    });

    $(document).on('click', '.set_gouvernorat', function(){

        var _idGouvernorat = $(this).attr( 'data-ajax' );
        var _nomGouvernorat = $(this).attr( 'data-field-name');
        $('#indicat_gouvenorat').text(_nomGouvernorat);
        $('#gouvernorat_label_text').text(_nomGouvernorat);

        $('#gouvernorat_id').val(_idGouvernorat);

        //display gouvernorat
        $('#list_elements_gouveronrat').hide( 'fade', {}, 'fast', function(){

            $('#header_index').hide( 'fade', {}, 'fast', function(){
                $(this).find('#title_choizir_gouvernorat').hide();
                $(this).find('#title_choizir_delegation').show();

                $(this).show( 'fade', {}, 'slow', function(){
                    displayElementDelegations(_idGouvernorat);
                });
            });

        });




    });

    $(document).on('click', '.set_delegation', function(){

        var _idDelegation = $(this).attr( 'data-ajax' );
        var _nomDelegation = $(this).attr( 'data-field-name');
        $('#indicat_delegation').text(_nomDelegation);
        $('#delegation_label_text').text(_nomDelegation);

        var _idGouvernorat = $('#gouvernorat_id').val();
        var _idSecteur = $('#secteur_id').val();

        $('#delegation_id').val(_idDelegation);

        //display gouvernorat
        $('#list_elements_delegations_' + _idGouvernorat).hide( 'fade', {}, 'fast', function(){

            $('#header_index').hide( 'fade', {}, 'fast', function(){
                $(this).find('#title_choizir_delegation').hide();
                $(this).find('#title_choizir_societe').show();

                $('.loading_data').show( 'fade', {}, 'fast', function(){
                    var _url_display_societe = _url + '/' + _idSecteur + '/' + _idDelegation;
                    getList(_url_display_societe, _dataRequest);
                });
            });

        });




    });

    $(document).on('click', '.add_dossier', function(){

        var _idSociete = $(this).attr( 'data-ajax' );
        var _nomSociete = $(this).attr( 'data-field-name');
        $('#societe_label_text').text(_nomSociete);

        $('#societe_id').val(_idSociete);

        var _selectorSociete = $(this);

        //display gouvernorat
        $('#list_elements').hide( 'fade', {}, 'fast', function(){

            swal({
                    title: _selectorSociete.attr('data-warning'),
                    text: $('#message_asked').html(),
                    type: "info",
                    html: true,
                    showCancelButton: true,
                    confirmButtonColor: "#00a918",
                    confirmButtonText: _selectorSociete.attr('data-confirm-buttontext'),
                    cancelButtonText: _selectorSociete.attr('data-cancel-buttonText'),
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {


                        var _url_action = $('#api').find('#store').val();

                        var _dataRequestAction = {
                            _token : _csrf_token,
                            societe_id : _idSociete
                        };

                        creatDossier(_url_action, _dataRequestAction);


                    } else {
                        $('#list_elements').show( 'fade', {}, 'slow');

                    }
                }
            );

        });




    });

    // for searche filtre
    $('#input-search').on('keyup', function() {
        var word_search = jQuery(this).val();

        var rex = new RegExp(word_search, 'i');

        $('#list_elements .container-card').hide();
        $('#list_elements .container-card').filter(function() {
            return rex.test($(this).find('.label_elemen_societe').text());
        }).show();
    });
});