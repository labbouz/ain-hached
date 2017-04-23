
$(document).ready(function(){

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $(document).on('click', '.send_message', function(){

        var _selectorForm = $(this).closest('.form_send');

        _selectorForm.find('form').hide('fade', {}, 500, function(){
            _selectorForm.find('.message_succes_send').show('fade', {}, 500, function(){
                $(this).delay(3000).hide('fade', {}, 500, function(){
                    _selectorForm.find('form').show('fade', {}, 500);
                });
            });
        });
    });

});