

$(document).ready(function(){

    var getDataFiltre = function() {

        var _selectGouvernorat = $('#search_gouvernorat').val();
        var _selectSecteur = $('#search_secteur').val();
        var val_roles = [];
        $('.checkbox_role:checkbox:checked').each(function(i){
            val_roles[i] = $(this).val();
        });



        $('#list_elements > .container-card').each(function( ) {
            var _selectorCard = $(this);
            var _dtaRoleCard = _selectorCard.attr('data-role');
            var _dtaGovCard = _selectorCard.attr('data-gouvernorat');
            var _dtaSectCard = _selectorCard.attr('data-secteur');
            var _indexSearch = val_roles.indexOf(_dtaRoleCard);

            var _show = 0;



            // filtre by role
            if(_indexSearch >= 0) {
                _show = 1;

                // filtre by grouvernorat
                switch (_dtaRoleCard) {
                    case 'administrator':
                        _show = 1;
                        break;
                    case 'observateur_regional':
                    case 'observateur':
                        if(_selectGouvernorat == '0') {
                            _show = 1;
                        } else{
                            if(_selectGouvernorat == _dtaGovCard) {
                                _show = 1;
                            } else {
                                _show = 0;
                            }
                        }
                        break;
                    case 'observateur_secteur':
                        if(_selectSecteur == '0') {
                            _show = 1;
                        } else{
                            if(_selectSecteur == _dtaSectCard) {
                                _show = 1;
                            } else {
                                _show = 0;
                            }
                        }
                        break;
                }


            } else {
                _show = 0;
            }


            if(_show) {
                _selectorCard.show('fade', {}, 'fast');
            } else {
                _selectorCard.hide('fade', {}, 'fast');
            }
        });




    };

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

    $(document).on('click', '.send_message', function(){

        var _selectorForm = $(this).closest('.form_send');

        _selectorForm.find('form').hide('fade', {}, 500, function(){
            _selectorForm.find('.message_succes_send').show('fade', {}, 500, function(){
                _selectorForm.find('form')[0].reset();
                $(this).delay(3000).hide('fade', {}, 500, function(){
                    _selectorForm.find('form').show('fade', {}, 500);
                });
            });
        });
    });

    $(document).on('click', '.checkbox', function(){
        getDataFiltre();
    });

    $(document).on('click', '.checkbox', function(){

    });

    $('#search_gouvernorat').on('change', function() {
        getDataFiltre();
    });

    $('#search_secteur').on('change', function() {
        getDataFiltre();
    });


});