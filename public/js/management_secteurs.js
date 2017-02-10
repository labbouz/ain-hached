

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
                    _container = _container.replace(new RegExp("{"+index+"}", 'g'), data);
                });

                $('#list_elements').append(_container);

                if (!--count) displayElement();

            });
        });




    };


    var displayElement = function() {

        var _delay = 800;
        $('#list_elements > .container-card').each(function( index ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            _delay = _delay + 100;
        });
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

    function addElement(url, data) {
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

    function updateElement(url, data_elemen, id_elemen) {

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

                    _selectorContainer.find( '.label_elemen' ).find( 'span' ).text(data_elemen.nom_secteur);
                    _selectorContainer.find( 'form' ).find( '#nom_secteur' ).attr('data-reset', data_elemen.nom_secteur);

                    _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                        _selectorContainer.find( '.edit_card' ).show('fade', {}, 'fast', function(){
                        });
                    });

                } else {
                    //console.log(data);
                    swal({
                        title: data.msg,
                        text: data.msg_text,
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });

                    _selectorContainer.find('.cancel_edit').trigger( "click" );
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

                _selectorContainer.find('.cancel_edit').trigger( "click" );
            }
        });

    }

    function setLoading() {
        var _container_loading = $('#template_loading').html();

        $('#header_loading').append(_container_loading).show();
    }

    /*********** Actions *************/

    $(document).on('click', '.add', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        $(this).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box' ).show('fade', {}, 'fast');
        });


    });


    $(document).on('click', '.edit', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        _selectorContainer.find('.edit_card').hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box' ).show('fade', {}, 'fast');
        });


    });

    $(document).on('click', '.cancel_add', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.add' ).show('fade', {}, 'fast', function(){
                _selectorContainer.find( 'form' )[0].reset();
            });
        });


    });

    $(document).on('click', '.cancel_edit', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.edit_card' ).show('fade', {}, 'fast', function(){
               // reset edit
                _selectorContainer.find( 'form' ).find('input').each(function(){
                    var recap =$(this).attr('data-reset');
                    $(this).val(recap);
                })
            });
        });


    });

    $(document).on('click', '.save_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
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
                        nom_secteur : $('#nom_secteur').val()
                    };

                    addElement(_url_action, _dataRequestAction);

                });
            });

        }

    });


    $(document).on('click', '.update_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
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
                        nom_secteur : form.find('#nom_secteur').val(),
                        _method: "PATCH"
                    };

                    updateElement(_url_action, _dataRequestAction, _idElement);

                });
            });

        }

    });

    $(document).on('click', '.remove', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        swal({
                title: $(this).attr('data-warning'),
                text: $(this).attr('data-text-warning'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4F5467",
                confirmButtonText: $(this).attr('data-confirm-buttontext'),
                cancelButtonText: $(this).attr('data-cancel-buttonText'),
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                } else {
                    swal("Cancelled", "error");
                }
            });
    });
    /*

     var _idElement = form.attr('data-id');

     var _url_action = $('#api').find('#store').val();
     _url_action = _url_action + '/' + _idElement;

     var _dataRequestAction = {
     _token : _csrf_token,
     nom_secteur : form.find('#nom_secteur').val(),
     _method: "PATCH"
     };

     //removeElement(_url_action, _dataRequestAction, _idElement);


     */

});