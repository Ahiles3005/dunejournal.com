global.$ = require("jquery");
import 'select2';
import './custom_libs/jquery.richtext.min';
import 'bootstrap';

let callback;

let GALLERY_FILES = {};
let IMAGES_TO_DEL = {};
let i = 0;

// Show errors
window.showError = (message, popup = '#result-modal') => {
    $(popup).modal('show');
    $(`${popup} .modal-title`).html('Ошибка');
    $(`${popup} .messages`).empty();
    let errors = message;
    $(`${popup} .messages`).append('<ul class="list-unstyled">');

    let values = errors.error != null ? errors.error : errors;

    if( Array.isArray(values) ){
        $.each(values, function(key, item){
            $(`${popup} .messages ul`).append(`<li class="alert alert-danger">${item}</li>`);
        });
    } else {
        $(`${popup} .messages ul`).append(`<li class="alert alert-danger">${errors}</li>`);
    }

    $(`${popup} .messages`).append('</ul>');
}

// Show message
window.showMessage = (message, popup = "#result-modal", type = '') => {
    $(popup).modal('show');
    if( type == 'success'){
        $(`${popup} .modal-title`).html('Успешно');
    } else {
        $(`${popup} .modal-title`).html('Сообщение');
    }

    $(`${popup} .messages`).empty();

    $(`${popup} .messages`).html(`<div class="alert alert-success" role="alert">${message}</div>`);
}

// Info about tag
$(document).on('click', '.info-tag', function () {

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    $.post("/control-panel/tag/info", params,
        function (data, textStatus, jqXHR) {
            console.log(data);

            if(data.error != null) {
                showError(data.error);
                return;
            }

            $.each(data, function(key, value){
                $(`input[name="${key}"]`).val(value);
            });

            $(`select[name="is_hot"]`).val(data.is_hot);
        }
    );
});

// Delete tag
$(document).on('click', '.del-tag', function () {
    $('#tags-remove-popup').modal('show');

    let trClosest = $(this).closest('tr');

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    callback = setCallback("/control-panel/tag/delete", params, trClosest);
});

// Info about category
$(document).on('click', '.info-category', function () {

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    $.post("/control-panel/category/info", params,
        function (data, textStatus, jqXHR) {
            console.log(data);

            if(data.error != null) {
                showError(data.error);
                return;
            }

            $.each(data, function(key, value){
                $(`input[name="${key}"]`).val(value);
            });

        }
    );
});

// Delete category
$(document).on('click', '.del-category', function () {
    $('#categories-remove-popup').modal('show');

    let trClosest = $(this).closest('tr');

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    callback = setCallback("/control-panel/category/delete", params, trClosest);
});

// Info about news
$(document).on('click', '.info-news', function () {

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    IMAGES_TO_DEL = {};
    $('.current-gallery').empty();

    $.post("/control-panel/news/info", params,
        function (data, textStatus, jqXHR) {
            console.log(data);

            if(data.error != null) {
                showError(data.error);
                return;
            }

            $.each(data, function(key, value){
                if(key == 'asset_url' || key == 'full_image') return;
                $(`#news-popup input[name="${key}"]`).val(value);
            });

            $(`#news-popup select[name="type"]`).val(data.type);
            $(`#news-popup [name="short_descr"]`).val(data.short_descr);
            $(`#news-popup [name="full_descr"]`).val(data.full_descr).trigger('change');

            $('#news-popup .current-asset').empty();
            $('#news-popup [name="asset"]').val('');

            $('#news-popup .current-full_image').empty();
            $('#news-popup [name="full_image"]').val('');

            if(data.asset_url != null){

                if( isVideo(data.asset_url) ) {
                    $('#news-popup .current-asset').html(`
                    <video width="198" height="345" controls>
                        <source src="${data.asset_url}">
                        Your browser does not support the video tag.
                    </video>
                    `);
                } else {
                    $('#news-popup .current-asset').html(`<img src="${data.asset_url}" alt="" class="img-fluid asset">`);
                }
            }

            if(data.full_image != null){
                $('#news-popup .current-full_image').html(`<img src="${data.full_image}" alt="" class="img-fluid asset">`);
            }

            let tags = [];
            let categories = [];

            $.each(data.tags, function(key, value){
                tags.push(value.tag_id.toString());
            });

            $.each(data.categories, function(key, value){
                categories.push(value.category_id.toString());
            });

            $.each(data.carousel, function(key, value){
                $('.current-gallery').append(`
                    <div class="gallery-item" data-key="${value.id}">
                        <img src="${value.asset_url}" alt="" class="img-fluid asset m-2">
                        <button type="button" class="btn btn-danger del-gallery-item"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                `);
                i = value.id;
            });

            $('#news-popup select[name="tags[]"]').val(tags).trigger('change');
            $('#news-popup select[name="categories[]"]').val(categories).trigger('change');
        }
    );
});

// Delete news
$(document).on('click', '.del-news', function () {
    $('#news-remove-popup').modal('show');

    let trClosest = $(this).closest('tr');

    let params = {
        _token: $('[name="_token"]').val(),
        id: $(this).attr('data-id')
    };

    callback = setCallback("/control-panel/news/delete", params, trClosest);
});

// On asset changed
$(document).on('change', 'input[name="asset"]', function() {
    $('input[name="del_asset"]').val(0);

    const file = this.files[0];
    if (file){
        let reader = new FileReader();
        reader.onload = function(event){
            console.log(event.target);

            let result = event.target.result;
            if(result.indexOf('video') > -1) {
                $('.current-asset').html(`
                <video width="198" height="345" controls>
                    <source src="${result}">
                    Your browser does not support the video tag.
                </video>
                `);
            } else {
                $('.current-asset').html(`<img src="${result}" alt="" class="img-fluid asset">`);
            }
        }
        reader.readAsDataURL(file);
    }
});

// On full image changed
$(document).on('change', 'input[name="full_image"]', function() {
    $('input[name="del_full_image"]').val(0);

    const file = this.files[0];
    if (file){
        let reader = new FileReader();
        reader.onload = function(event){
            console.log(event.target);

            let result = event.target.result;
            $('.current-full_image').html(`<img src="${result}" alt="" class="img-fluid asset">`);
        }
        reader.readAsDataURL(file);
    }
});

// On gallery changed
$(document).on('change', 'input[name="gallery"]', function() {
    const files = this.files;

    $.each(files, function (key, value) {
        let reader = new FileReader();
        reader.onload = function(event){
            console.log(event.target);

            let result = event.target.result;
            i++;

            $('.current-gallery').append(`
                <div class="gallery-item" data-key="${i}">
                    <img src="${result}" alt="" class="img-fluid asset m-2">
                    <button type="button" class="btn btn-danger del-gallery-item"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            `);

            GALLERY_FILES[i] = value;

            //i++;
        }
        reader.readAsDataURL(value);
    });

});

// Submit form: `news-add`
$("#news-add").on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let actionUrl = form.attr('action');
    let method = form.attr('method');

    let formData = new FormData();
    let serializedForm = form.serializeArray();

    $.each(serializedForm, function(key, value) {
        formData.append(value.name, value.value);
    });

    let assets = {
        short: $(this).find('input[name="asset"]')[0].files[0],
        full: $(this).find('input[name="full_image"]')[0].files[0]
    }

    if(assets.short != null) formData.append('asset', assets.short);
    if(assets.full != null) formData.append('full_image', assets.full);

    $.each(GALLERY_FILES, function(key, value){
        formData.append(`gallery[${key}]`, value);
    });

    $.ajax({
        type: method,
        url: actionUrl,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            if(data.error != null) {
                showError(data.error);
                return;
            }

            $('#news-add-popup').find('input:not([name="_token"]), select, textarea').val('');
            $('.current-asset').empty();
            $('.current-full_image').empty();
            $('.current-gallery').empty();

            $('#news-add-popup .description').val('').trigger('change');

            $('#news-add-popup [name="tags[]"]').val(null).trigger('change');
            $('#news-add-popup [name="categories[]"]').val(null).trigger('change');

            $('#news-add-popup').modal('hide');
            showMessage(data.success);

            GALLERY_FILES = {};
            i = 0;

            //location.reload();
        }
    });
});

// Submit form: `news-edit`
$("#news-edit").on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let actionUrl = form.attr('action');
    let method = form.attr('method');

    let formData = new FormData();
    let serializedForm = form.serializeArray();

    $.each(serializedForm, function(key, value) {
        formData.append(value.name, value.value);
    });

    let assets = {
        short: $(this).find('input[name="asset"]')[0].files[0],
        full: $(this).find('input[name="full_image"]')[0].files[0]
    }

    if(assets.short != null) formData.append('asset', assets.short);
    if(assets.full != null) formData.append('full_image', assets.full);

    $.each(GALLERY_FILES, function(key, value){
        formData.append(`gallery[${key}]`, value);
    });

    $.each(IMAGES_TO_DEL, function(key, value){
        formData.append(`delete_images[${key}]`, value);
    });

    $.ajax({
        type: method,
        url: actionUrl,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            if(data.error != null) {
                showError(data.error);
                return;
            }

            /* $('#news-popup').find('input:not([name="_token"]), select, textarea').val('');
            $('.current-asset').empty();
            $('.current-full_image').empty();
            $('.current-gallery').empty();

            $('#news-popup .description').val('').trigger('change');

            $('#news-popup [name="tags[]"]').val(null).trigger('change');
            $('#news-popup [name="categories[]"]').val(null).trigger('change');

            $('#news-popup').modal('hide');
            showMessage(data.success);

            GALLERY_FILES = {};
            i = 0; */

           // console.log(data);

           location.reload();
        }
    });
});

// On asset removed
$(document).on('click', '.del-asset', function () {
    $('.current-asset').empty();
    $('input[name="asset"]').val('');
    $('input[name="del-asset"]').val(1);
});

// On full image removed
$(document).on('click', '.del-full_image', function () {
    $('.current-full_image').empty();
    $('input[name="full_image"]').val('');
    $('input[name="del_full_image"]').val(1);
});

// On gallery item removed
$(document).on('click', '.del-gallery-item', function () {
    let parent = $(this).parent();
    let id = $(parent).attr('data-key');
    //GALLERY_FILES = GALLERY_FILES.filter(item => item !== id);
    if(GALLERY_FILES[id] != null) {
        delete GALLERY_FILES[id];
    } else {
        IMAGES_TO_DEL[id] = id;
    }

    $(this).parent().remove();
});

////////////////////////
// On entity deleted
$(document).on('click', '#delete-entity', function(){
    $(this).closest('.modal').modal('hide');
    callback();
});

/**
 * FUNCTIONS
 */

function setCallback(url, params, parent){
    return function(){
        $.post(url, params,
            function (data, textStatus, jqXHR) {
                console.log(data);

                if(data.error != null) {
                    showError(data.error);
                    return;
                }

                $(parent).remove();
                showMessage(data.success);
            }
        );
    };
}

function isVideo(url){
    let videoExtensions = ['mp4', 'ogg', 'webm'];

    let isVideo = false;
    $.each( videoExtensions, function( key, value ) {
        if(url.toLowerCase().indexOf(value) > -1) {
            isVideo = true;
            return false;
        }
    });

    return isVideo;
}

