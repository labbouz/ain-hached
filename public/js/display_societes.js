

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


});