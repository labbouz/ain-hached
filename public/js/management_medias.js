

$(document).ready(function(){


    var _url = $('#api').find('#index').val();

    var _csrf_token = $('#api').find('input[name="_token"]').val();

    var _dataRequest = {
        _token : _csrf_token
    };

    /************* Initialisation ***/
    setLoading();
    getList(_url, _dataRequest);

    var loadElements = function(elements) {

        var _container_form = $('#template_form_add').html();

        $('#list_elements').append(_container_form).show('fade', {}, 'fast', function() {

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

                $('.header_action_active').hide('fade', {}, 500, function(){
                    $('#header_index').show('fade', {}, 800, function(){
                        $(this).addClass('header_action_active');
                    });
                });

                if(data.status == 'success') {
                    loadElements(data.elements);
                } else {
                    console.log(data);
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    }

    function addElement(url, data, _selectorContainer) {

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'json',
            success: function(data) {

                if(data.status == 'success') {
                    swal({
                        title: data.msg,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    downModEdit();

                    $('#list_elements').html('');
                    getList(_url, _dataRequest);
                } else {
                    //console.log(data);
                    swal({
                        title: data.msg,
                        text: data.msg_text,
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });

                    _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                        $('.cancel_add').trigger( "click" );
                    });
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

                _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                    $('.cancel_add').trigger( "click" );
                });
            }
        });
    }

    function updateElement(url, data_elemen, id_elemen) {
        //console.log(data_elemen);
        var _selectorContainer = $("#id_"+id_elemen).find( ".container_element" );

        $.ajax({
            type: 'PATCH',
            url: url,
            data: data_elemen,
            dataType: 'json',
            success: function(data) {

                if(data.status == 'success') {
                    swal({
                        title: data.msg,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    _selectorContainer.find( '.label_elemen' ).find( 'span' ).text(data_elemen.nom_media);
                    _selectorContainer.find( 'form' ).find( '#nom_media' ).attr('data-reset', data_elemen.nom_media);
                    _selectorContainer.find( 'form' ).find( '#categorie_media_id' ).attr('data-reset', data_elemen.categorie_media_id);

                    _selectorContainer.find('#indicat_element').attr('class', 'indicat categorie_media_'+data_elemen.categorie_media_id);

                    _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                        _selectorContainer.find( '.edit_card' ).show('fade', {}, 'fast', function(){
                        });
                    });

                    downModEdit();

                } else {
                    //console.log(data);
                    swal({
                        title: data.msg,
                        text: data.msg_text,
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });

                    _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                        _selectorContainer.find('.cancel_edit').trigger( "click" );
                    });
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

                _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                    _selectorContainer.find('.cancel_edit').trigger( "click" );
                });
            }
        });

    }

    function removeElement(url, data_elemen, id_elemen) {

        var _selectorContainerCard = $("#id_"+id_elemen);

        $.ajax({
            type: 'DELETE',
            url: url,
            data: data_elemen,
            dataType: 'json',
            success: function(data) {

                if(data.status == 'success') {
                    swal({
                        title: data.msg,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $(document).trigger( "click" );

                    _selectorContainerCard.hide('fade', {}, 'fast', function(){
                        $(this).remove();
                    });


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
            }
        });

    }

    function setLoading() {
        var _container_loading = $('#template_loading').html();

        $('#header_loading').append(_container_loading).show();
    }

    function setModEdit() {
        $('#list_elements').addClass('bg_detail_active');
    }

    function downModEdit() {
        $('#list_elements').removeClass('bg_detail_active');
    }

    /*********** Actions *************/

    $(document).on('click', '.add', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        setModEdit();

        $(this).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box' ).show('fade', {}, 'fast');
        });


    });


    $(document).on('click', '.edit', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        setModEdit();

        $( ".container-card" ).each(function() {
            if( $(this).find('.form-box').is(':visible') ) {
               $(this).find('.cancel_edit').trigger( "click" );
            }
        });

        _selectorContainer.find('.edit_card').hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box' ).show('fade', {}, 'fast');
        });


    });

    $(document).on('click', '.cancel_add', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        downModEdit();
        _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.add' ).show('fade', {}, 'fast', function(){
                _selectorContainer.find( 'form' )[0].reset();
            });
        });


    });

    $(document).on('click', '.cancel_edit', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        downModEdit();
        _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.edit_card' ).show('fade', {}, 'fast', function(){
               // reset edit for input
                _selectorContainer.find( 'form' ).find('input').each(function(){
                    var recap =$(this).attr('data-reset');
                    $(this).val(recap);
                });
                // reset edit for textarea
                _selectorContainer.find( 'form' ).find('textarea').each(function(){
                    var recap =$(this).attr('data-reset');
                    $(this).val(recap);
                });
                // reset edit for select
                _selectorContainer.find( 'form' ).find('select').each(function( ) {
                    var _valDefault = $(this).attr('data-reset');
                    $(this).val(_valDefault);
                });

            });
        });


    });

    $(document).on('click', '.save_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
            rules: {
                categorie_media_id: {
                    required: true,
                    min: 1
                }
            },
            errorPlacement: function(error, element) {
                // /just nothing, empty
            },
            invalidHandler: function() {

                swal({
                    title: form.attr('data-error'),
                    type: "error",
                    confirmButtonColor: "#4F5467"
                });

            }
        });

        if( form.valid() ) {

            _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
                _selectorContainer.find( '.loader' ).show('fade', {}, 'fast', function(){

                    var _url_action = $('#api').find('#store').val();

                    var _dataRequestAction = {
                        _token : _csrf_token,
                        nom_media : form.find('#nom_media').val(),
                        categorie_media_id : form.find('#categorie_media_id').val()
                    };

                    addElement(_url_action, _dataRequestAction, _selectorContainer);

                });
            });

        }

    });


    $(document).on('click', '.update_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
            rules: {
                categorie_media_id: {
                    required: true,
                    min: 1
                }
            },
            errorPlacement: function(error, element) {
                // /just nothing, empty
            },
            invalidHandler: function() {

                swal({
                    title: form.attr('data-error'),
                    type: "error",
                    confirmButtonColor: "#4F5467"
                });

            }
        });

        if( form.valid() ) {

            _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
                _selectorContainer.find( '.loader' ).show('fade', {}, 'fast', function(){

                    var _idElement = form.attr('data-id');

                    var _url_action = $('#api').find('#store').val();
                    _url_action = _url_action + '/' + _idElement;

                    var _dataRequestAction = {
                        _token : _csrf_token,
                        nom_media : form.find('#nom_media').val(),
                        categorie_media_id : form.find('#categorie_media_id').val(),
                        _method: "PATCH"
                    };

                    updateElement(_url_action, _dataRequestAction, _idElement);

                });
            });

        }

    });

    $(document).on('click', '.remove', function(){

        var _selectoRemove = $(this);
        var _selectorContainer = _selectoRemove.closest( ".container_element" );

        var form = _selectorContainer.find('form');

        swal({
                title: _selectoRemove.attr('data-warning'),
                text: _selectoRemove.attr('data-text-warning'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4F5467",
                confirmButtonText: _selectoRemove.attr('data-confirm-buttontext'),
                cancelButtonText: _selectoRemove.attr('data-cancel-buttonText'),
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm){
                if (isConfirm) {

                    var _idElement = form.attr('data-id');

                    var _url_action = $('#api').find('#store').val();
                    _url_action = _url_action + '/' + _idElement;

                    var _dataRequestAction = {
                        _token : _csrf_token,
                        _method: "DELETE"
                    };

                    removeElement(_url_action, _dataRequestAction, _idElement);


                } else {
                    swal({
                        title: _selectoRemove.attr('data-cancelled'),
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });
                }
            });
    });

});