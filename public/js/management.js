

$(document).ready(function(){


    var _url = $('#api').find('#index').val();
    var _csrf_token = $('#api').find('input[name="_token"]').val();

    var _dataRequest = {
        _token : _csrf_token
    };

    /************* Initialisation ***/
    getList(_url, _dataRequest);

    var loadElements = function(elements) {

        var count = elements.length;
        $.each(elements, function (key, data) {
            var _container = $('#template_container').html();

            $.each(data, function (index, data) {
                _container = _container.replace("{"+index+"}", data);
            });

            $('#list_elements').append(_container);

            if (!--count) displayElement();

        });


    };


    var displayElement = function() {

        var _delay = 800;
        $('#list_elements > .container-card').each(function( index ) {
            $(this).delay(_delay).show('scale', {
                duration: 300,
                direction : 'vertical',
                origin:['middle','center'],
                easing: 'easeOutBack'
            });

            _delay = _delay + 100;
        });
    };

    var setFormAdd = function() {

        var _container_form = $('#template_form_add').html();

        $('#espace_form').append(_container_form).show('scale', {
            duration: 500,
            direction : 'vertical',
            origin:['top','center'],
            easing: 'easeOutBack'
        });
    };



    function getList(url, data) {

        setLoading();

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
                    $('.tool_bar_action').delay(500).show('fade', {}, 800, function(){

                    });
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

    function setLoading() {
        var _container_loading = $('#template_loading').html();

        $('#header_loading').append(_container_loading).show();
    }

    /*********** Actions *************/

    $(document).on('click', '.add', function(){

        $('.tool_bar_action').hide('scale', {
            duration: 500,
            origin:['top','center'],
            easing: 'easeInBack'
        }, function(){

        });

        $('.header_action_active').hide('fade', {}, 300, function(){

            $('#header_add').show('fade', {}, 800, function(){
                $(this).addClass('header_action_active');
            });
        });

        $('#list_elements').hide('scale', {
                duration: 500,
                origin:['middle','center'],
                easing: 'easeInBack'
            }, function(){
                setFormAdd();
        });


    });

    $(document).on('click', '#list_elements .card', function(){
        alert('OK');
    });






});