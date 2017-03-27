

$(document).ready(function(){



    var displayElement = function() {

        var _delay = 0;
        $('#list_elements > .container-card').each(function( ) {
            $(this).delay(_delay).show('fade', {}, 'fast');

            _delay = _delay + 100;
        });

    };

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    displayElement();

    /************************************************************************/
    /******************************** Add File ********************************/
    /************************************************************************/

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
                            timer: 2000,
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

    var _csrf_token = $('#api').find('input[name="_token"]').val();

    // For add new file
    $(document).on('click', '.add-dossier', function(){
        var _idSociete = $(this).attr( 'data-ajax' );
        var _selectorSociete = $(this);

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

    /************************************************************************/
    /****************************** Remove File *******************************/
    /************************************************************************/
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


                    _selectorContainerCard.hide('fade', {}, 'fast', function(){
                        $(this).remove();
                    });


                } else {
                    swal({
                        title: data.msg,
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

    $(document).on('click', '.remove', function(){

        var _selectoRemove = $(this);
        var _selectorContainer = _selectoRemove.closest( ".container-card" );

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

                    var _idElement = _selectorContainer.attr('data-id');

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