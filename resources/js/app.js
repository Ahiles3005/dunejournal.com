global.$ = require("jquery");
import 'slick-carousel';

$(function(){

    /* Check weather */
    const COORDINATES = [25.08, 55.31]; // Dubai
    $.get(`https://api.open-meteo.com/v1/forecast?latitude=${COORDINATES[0]}&longitude=${COORDINATES[1]}&current_weather=true`, {},
        function (data, textStatus, jqXHR) {
            console.log(data);
            if(jqXHR.status == 200){
                $('#temperature').html(data.current_weather.temperature);
                let timestamp = Date.parse(data.current_weather.time);
                let date = new Date(timestamp);
                let parsedDate = date.getDate()+"."+(date.getMonth()+1)+"."+date.getFullYear();
                $('#calendar').html(parsedDate);
            }
        }
    );

    /* On tag hover */
    $('.leftbar .tag').on({
        mouseenter: function () {
            let hoverColor = $(this).attr('data-hover_color');
            console.log(hoverColor);
            if(hoverColor == null) return;

            $(this).css('background', hoverColor);
        },
        mouseleave: function () {
            $(this).css('background', 'white');
        }
    });

    /* On tag dropdown clicked */
    $('.tag-selected').on('click', function(){
        if( $(this).hasClass('closed') ){
            $('.tags-list').fadeIn(300);
            $('.tag-arrow').addClass('tag-arrow-rotated');
            $(this).removeClass('closed');
        } else {
            $('.tags-list').fadeOut(300);
            $('.tag-arrow').removeClass('tag-arrow-rotated');
            $(this).addClass('closed');
        }
    });

    /* On tag choosen */
    $('.tag').on('click', function(){
        $('.tag-selected span').html( $(this).html() );
        $('.tags-list').fadeOut(300);
        $('.tag-arrow').removeClass('tag-arrow-rotated');
        $('.tag-selected').addClass('closed');
    });

    /* Search by text */
    $('#search-send').on('click', function(){
        let params = {
            value: $('#search-value').val(),
            _token: $('[name="_token"]').val()
        };

        $.post('/search', params,
            function (data, textStatus, jqXHR) {
                console.log(data);

                if(data.error != null){
                    showMessage('error', data.error);
                }

                $('.content-limited').empty();

                $('.content-limited').html(data).hide().fadeIn(400);
            }
        );
    });

    /* Search by tag*/
    /* $('.tag, .tag-anchor').on('click', function () {
        let params = {
            tag: $(this).attr('data-id'),
            _token: $('[name="_token"]').val()
        };

        $.post('/tag/filter', params,
            function (data, textStatus, jqXHR) {
                console.log(data);

                if(data.error != null){
                    showMessage('error', data.error);
                }

                $('.content-limited').empty();

                $('.content-limited').html(data).hide().fadeIn(400);
            }
        );
    }); */

    ////////////////////////////////
    /* On toolbar buttons clicked */
    $('.btn-toolbar').on('click', function(){
        if( $(this).parent().hasClass('hidden') ){
            $('.toolbar-content').fadeIn(300);
            $(this).parent().removeClass('hidden');
        } else {
            if( $(this).hasClass('btn-search') ){
                $('#search-value').focus();
            } else {
                $('.toolbar-content').fadeOut(300);
                $(this).parent().addClass('hidden');
            }
        }

        if( $(this).hasClass('btn-search') ){
            $('#search-value').focus();
        }
    });

    $('.minimize').on('click', function () {
        $('.toolbar-content').fadeOut(300);
        $('.toolbar__buttons').addClass('hidden');
    });

    /* Mob menu */
    $('.burger').on('click', function () {
        if( $(this).hasClass('active') ){
            $('.mob-nav__content').slideUp(300);
            $(this).removeClass('active');
        } else {
            $('.mob-nav__content').slideDown(300);
            $(this).addClass('active');
        }
    });
});

window.showMessage = function(type, message){
    $('.alert').removeClass('error');
    $('.alert').removeClass('success');
    $('.alert span').empty();
    $('.alert').addClass(type);
    $('.alert').fadeIn(300);
    $('.alert span').html(message);
    setTimeout(function (){
        $('.alert').fadeOut(300);
    }, 5000);
}

window.copy = function (element) {
    let input = document.createElement('textarea');
    input.innerHTML = $(element).attr('href');
    document.body.appendChild(input);
    input.select();
    let result = document.execCommand('copy');
    document.body.removeChild(input);
    showMessage('success', 'Вы успешно скопировали ссылку на новость!');
    return result;
}
