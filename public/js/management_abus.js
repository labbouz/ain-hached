

$(document).ready(function(){


    var _url = $('#api').find('#index').val();

    var _csrf_token = $('#api').find('input[name="_token"]').val();

    var _dataRequest = {
        _token : _csrf_token
    };



    /************* Initialisation ***/
    setLoading();
    getList(_url, _dataRequest);

    $('[data-toggle="tooltip"]').tooltip();

    var setCountElement = function(_count) {
        $('.count').text(_count);
    };

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
                if(_valDefault) {
                    $(this).find('option[value='+_valDefault+']').attr('selected','selected');
                }

            });

            _delay = _delay + 100;
        });

        $('[data-toggle="tooltip"]').tooltip();

    };

    function getDateToDay() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd='0'+dd
        }

        if(mm<10) {
            mm='0'+mm
        }

        today = yyyy+'-'+mm+'-'+dd;

        return today;
    }

    function dateValide(value_date) {
        res = value_date.split("/");
        var year_v = res[2];
        var month_v = parseInt(res[1]);
        var day_v = parseInt(res[0]);

        if(month_v>12 || day_v > 31) {
            return false;
        }
        if(month_v<10) {
            month_v='0'+month_v
        }

        if(day_v<10) {
            day_v='0'+day_v
        }

        day_v = year_v+'-'+month_v+'-'+day_v;

        if( day_v > getDateToDay() ) {
            return false
        }

        return true;

    }

    function getList(url, data) {

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'json',
            success: function(data) {
                // success logic
                console.log(data);
                $('.header_action_active').hide('fade', {}, 500, function(){
                    $('#header_index').show('fade', {}, 800, function(){
                        $(this).addClass('header_action_active');
                    });
                });


                if(data.status == 'success') {
                    // update nomber element
                    setCountElement(data.elements.length);

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
                console.log(data);
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

        var dataTypeViolation = _selectorContainer.attr('data-type-violation');

        var _form = _selectorContainer.find( '.form-box' ).find( 'form' );

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



                    _selectorContainer.find( '.label_elemen' ).find( '.date_abus' ).find('strong').text(data_elemen.date_violation);
                    _selectorContainer.find( '.label_elemen' ).find( 'span.info_endommage' ).find('strong').text(data.info_endommage);

                    _selectorContainer.find( '.label_elemen' ).find( '#display_status_reglement' ).attr("class","fa statut_reglement statut_reglement_"+data_elemen.statut_reglement);
                    _selectorContainer.find( '.label_elemen' ).find( '#display_status_reglement' ).attr("title",data.resultat_violation);

                    if(dataTypeViolation == '1') {
                        _form.find( '#date_violation' ).attr('data-reset', data_elemen.date_violation);
                        _form.find( '#statut_reglement' ).attr('data-reset', data_elemen.statut_reglement);
                        _form.find( '#structure_syndicale_id' ).attr('data-reset', data_elemen.structure_syndicale_id);

                        _form.find( '#prenom_endommage' ).attr('data-reset', data_elemen.prenom_endommage);
                        _form.find( '#nom_endommage' ).attr('data-reset', data_elemen.nom_endommage);
                        _form.find( '#genre' ).attr('data-reset', data_elemen.genre);
                        _form.find( '#age' ).attr('data-reset', data_elemen.age);
                        _form.find( '#etat_civile' ).attr('data-reset', data_elemen.etat_civile);
                        _form.find( '#nb_enfant' ).attr('data-reset', data_elemen.nb_enfant);
                        _form.find( '#phone_number' ).attr('data-reset', data_elemen.phone_number);
                        _form.find( '#email' ).attr('data-reset', data_elemen.email);
                        _form.find( '#type_contrat' ).attr('data-reset', data_elemen.type_contrat);
                        _form.find( '#anciennete' ).attr('data-reset', data_elemen.anciennete);
                    }



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
                console.log(data);
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

    function updateAgresseurElement(url, data_elemen, id_elemen) {
        //console.log(data_elemen);
        var _selectorContainer = $("#id_"+id_elemen).find( ".container_element" );

        var _form = _selectorContainer.find( '.form-box-gresseur' ).find( 'form' );

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

                    _form.find( '#prenom_agresseur' ).attr('data-reset', data_elemen.prenom_agresseur);
                    _form.find( '#nom_agresseur' ).attr('data-reset', data_elemen.nom_agresseur);
                    _form.find( '#nationalite' ).attr('data-reset', data_elemen.nationalite);
                    _form.find( '#responsabilite_1' ).attr('data-reset', data_elemen.responsabilite_1);
                    _form.find( '#responsabilite_2' ).attr('data-reset', data_elemen.responsabilite_2);
                    _form.find( '#responsabilite_3' ).attr('data-reset', data_elemen.responsabilite_3);
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
                        _selectorContainer.find('.cancel_edit_gresseur').trigger( "click" );
                    });
                }
            },
            error: function(data){
                console.log(data);
                swal({
                    title: data.responseText,
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });

                _selectorContainer.find( '.loader' ).hide('fade', {}, 'fast', function(){
                    _selectorContainer.find('.cancel_edit_gresseur').trigger( "click" );
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
                    var _count = parseInt($('.count').text());

                    setCountElement(_count-1);

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
                        text: data.msg_text,
                        type: "error",
                        confirmButtonColor: "#4F5467"
                    });
                }
            },
            error: function(data){
                console.log(data);
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

    $(document).on('click', '.add1', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        setModEdit();

        $(this).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box' ).show('fade', {}, 'fast');
        });


    });

    $(document).on('click', '.add2', function(){

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

    $.validator.addMethod(
        "FrancaisDate",
        function(value, element) {
            // dd-mm-yyyy
            var re = /^\d\d?\/\d\d?\/\d\d\d\d$/;


            // valid if optional and empty OR if it passes the regex test
            return (this.optional(element) && value=="") || (re.test(value) && dateValide(value));
        }
    );

    $(document).on('click', '.save_element_1', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
            rules: {
                violation_id: {
                    required: true,
                    min: 1
                },
                date_violation: {
                    required: true,
                    FrancaisDate : true
                },
                structure_syndicale_id: {
                    required: true,
                    min: 1
                },
                genre: {
                    required: true
                },
                age: {
                    required: true,
                    number: true,
                    min: 1
                },
                nb_enfant: {
                    required: false,
                    number: true,
                    min: 0
                },
                phone_number: {
                    required: true,
                    number: true,
                    min: 0
                },
                email: {
                    required: false,
                    email: true
                },
                anciennete: {
                    required: true,
                    number: true,
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
                        violation_id : form.find('#violation_id').val(),
                        dossier_id : form.find('#dossier_id').val(),
                        date_violation : form.find('#date_violation').val(),
                        statut_reglement : form.find('#statut_reglement').val(),

                        prenom_endommage : form.find('#prenom_endommage').val(),
                        nom_endommage : form.find('#nom_endommage').val(),
                        structure_syndicale_id : form.find('#structure_syndicale_id').val(),
                        genre : form.find('#genre').val(),
                        age : form.find('#age').val(),
                        etat_civile : form.find('#etat_civile').val(),
                        nb_enfant : form.find('#nb_enfant').val(),
                        phone_number : form.find('#phone_number').val(),
                        email : form.find('#email').val(),
                        type_contrat : form.find('#type_contrat').val(),
                        anciennete : form.find('#anciennete').val(),


                        prenom_agresseur : form.find('#prenom_agresseur').val(),
                        nom_agresseur : form.find('#nom_agresseur').val(),
                        nationalite : form.find('#nationalite').val(),
                        responsabilite_1 : form.find('#responsabilite_1').val(),
                        responsabilite_2 : form.find('#responsabilite_2').val(),
                        responsabilite_3 : form.find('#responsabilite_3').val()
                    };

                    addElement(_url_action, _dataRequestAction, _selectorContainer);

                });
            });

        }

    });

    $(document).on('click', '.save_element_2', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find('form');

        form.validate({
            rules: {
                violation_id: {
                    required: true,
                    min: 1
                },
                date_violation: {
                    required: true,
                    FrancaisDate : true
                },
                structure_syndicale_id: {
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

                    var _url_action = $('#api').find('#store2').val();

                    var _dataRequestAction = {
                        _token : _csrf_token,
                        violation_id : form.find('#violation_id').val(),
                        dossier_id : form.find('#dossier_id').val(),
                        date_violation : form.find('#date_violation').val(),
                        statut_reglement : form.find('#statut_reglement').val(),
                        structure_syndicale_id : form.find('#structure_syndicale_id').val(),
                        prenom_agresseur : form.find('#prenom_agresseur').val(),
                        nom_agresseur : form.find('#nom_agresseur').val(),
                        nationalite : form.find('#nationalite').val(),
                        responsabilite_1 : form.find('#responsabilite_1').val(),
                        responsabilite_2 : form.find('#responsabilite_2').val(),
                        responsabilite_3 : form.find('#responsabilite_3').val()
                    };

                    addElement(_url_action, _dataRequestAction, _selectorContainer);

                });
            });

        }

    });

    $(document).on('click', '.update_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find( '.form-box' ).find('form');

        var dataTypeViolation = _selectorContainer.attr('data-type-violation');

        if(dataTypeViolation == '1') {
            form.validate({
                rules: {
                    prenom_endommage: {
                        required: true
                    },
                    nom_endommage: {
                        required: true
                    },
                    date_violation: {
                        required: true,
                        FrancaisDate : true
                    },
                    structure_syndicale_id: {
                        required: true,
                        min: 1
                    },
                    genre: {
                        required: true
                    },
                    age: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    nb_enfant: {
                        required: false,
                        number: true,
                        min: 0
                    },
                    phone_number: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    email: {
                        required: false,
                        email: true
                    },
                    anciennete: {
                        required: true,
                        number: true,
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
        } else {
            form.validate({
                rules: {
                    date_violation: {
                        required: true,
                        FrancaisDate : true
                    },
                    structure_syndicale_id: {
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
        }


        if( form.valid() ) {

            _selectorContainer.find( '.form-box' ).hide('fade', {}, 'fast', function(){
                _selectorContainer.find( '.loader' ).show('fade', {}, 'fast', function(){

                    var _idElement = form.attr('data-id');

                    var _url_action = $('#api').find('#store').val();
                    _url_action = _url_action + '/' + _idElement;


                    if(dataTypeViolation == '1') {
                        var _dataRequestAction = {
                            _token : _csrf_token,
                            date_violation : form.find('#date_violation').val(),
                            statut_reglement : form.find('#statut_reglement').val(),

                            prenom_endommage : form.find('#prenom_endommage').val(),
                            nom_endommage : form.find('#nom_endommage').val(),
                            structure_syndicale_id : form.find('#structure_syndicale_id').val(),
                            genre : form.find('#genre').val(),
                            age : form.find('#age').val(),
                            etat_civile : form.find('#etat_civile').val(),
                            nb_enfant : form.find('#nb_enfant').val(),
                            phone_number : form.find('#phone_number').val(),
                            email : form.find('#email').val(),
                            type_contrat : form.find('#type_contrat').val(),
                            anciennete : form.find('#anciennete').val(),

                            _method: "PATCH"
                        };
                    } else {
                        var _dataRequestAction = {
                            _token : _csrf_token,
                            date_violation : form.find('#date_violation').val(),
                            statut_reglement : form.find('#statut_reglement').val(),
                            structure_syndicale_id : form.find('#structure_syndicale_id').val(),
                            _method: "PATCH"
                        };
                    }



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

    $(document).on('click', '.edit_gresseur', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        setModEdit();

        $( ".container-card" ).each(function() {
            if( $(this).find('.form-box-gresseur').is(':visible') ) {
                $(this).find('.cancel_edit_gresseur').trigger( "click" );
            }
        });

        _selectorContainer.find('.edit_card').hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.form-box-gresseur' ).show('fade', {}, 'fast');
        });


    });

    $(document).on('click', '.cancel_edit_gresseur', function(){

        var _selectorContainer = $(this).closest( ".container_element" );
        var _form = _selectorContainer.find( '.form-box-gresseur' ).find( 'form' );

        downModEdit();
        _selectorContainer.find( '.form-box-gresseur' ).hide('fade', {}, 'fast', function(){
            _selectorContainer.find( '.edit_card' ).show('fade', {}, 'fast', function(){
                // reset edit for input
                _form.find('input').each(function(){
                    var recap =$(this).attr('data-reset');
                    $(this).val(recap);
                });
                // reset edit for textarea
                _form.find('textarea').each(function(){
                    var recap =$(this).attr('data-reset');
                    $(this).val(recap);
                });
                // reset edit for select
                _form.find('select').each(function( ) {
                    var _valDefault = $(this).attr('data-reset');
                    $(this).val(_valDefault);
                });

            });
        });


    });

    $(document).on('click', '.update_gresseur_element', function(){

        var _selectorContainer = $(this).closest( ".container_element" );

        var form = _selectorContainer.find( '.form-box-gresseur' ).find('form');

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

            _selectorContainer.find( '.form-box-gresseur' ).hide('fade', {}, 'fast', function(){
                _selectorContainer.find( '.loader' ).show('fade', {}, 'fast', function(){

                    var _idElement = form.attr('data-id');

                    var _url_action = $('#api').find('#store').val();
                    _url_action = _url_action + '/agresseur/' + _idElement;

                    var _dataRequestAction = {
                        _token : _csrf_token,

                        prenom_agresseur : form.find('#prenom_agresseur').val(),
                        nom_agresseur : form.find('#nom_agresseur').val(),
                        nationalite : form.find('#nationalite').val(),
                        responsabilite_1 : form.find('#responsabilite_1').val(),
                        responsabilite_2 : form.find('#responsabilite_2').val(),
                        responsabilite_3 : form.find('#responsabilite_3').val(),
                        _method: "PATCH"
                    };

                    updateAgresseurElement(_url_action, _dataRequestAction, _idElement);

                });
            });

        }

    });

});