$(document).on('submit', '#former_id', function(e) {

    e.preventDefault();

    // удаляем ошибки
    removeErrors();

    // проверяем выбраны ли файлы
    if( !hasInputFiles() || !checkMaxSize() ){
        return false;
    }

    var info = new FormData();

    var files = $('#preview').prop('files');
    // прикрепляем файлы
    $.each(files, function(i, file) {
        info.append('path['+ i + ']', file);
    });
    info.append('saver[submit]', $('#subm_button').val());

    // очищаем инпут
    clearInput();

    $.ajax({
        url: '/image/add', // point to server-side PHP script
        type: 'post',
        dataType: 'json',  // what to expect back from the PHP script, if anything
        async: true,
        cache: false,
        processData: false,
        contentType: false,
        data: info,
        beforeSend: function (data) {
            $('input[type="submit"]').attr('disabled', true); // Блокируем
            // показываем прелоадер
            var imgObj = $("#loadImg");
            imgObj.show();

            var centerY = $(window).scrollTop() + ($(window).height() + imgObj.height())/2;
            var centerX = $(window).scrollLeft() + ($(window).width() + imgObj.width())/2;

            imgObj.offset({top:centerY, left:centerX});
        },
        success: function (data, status, object) {

            if(data.errorFlag){
                var err = createErrorBlock(data.errors);
                $('header.content__header').after(err);
            }else{
                var ins = createImageView(data.info);
                $('ul.gif-list').append(ins);
            }
        },
        complete: function() {
            $('input[type="submit"]').attr('disabled', false); // Отменяем блокировку
            $("#loadImg").hide(); // убираем прелоадер
        },
        error: function (data, status, object) {
            var errStr = 'При ajax запросе произошла ошибка. Код: ' + data.status;
            var arr = [errStr];
            var err = createErrorBlock(arr);
            $('header.content__header').after(err);
        }
    });
});

function createErrorBlock(errMsg){
    var html = '';
    html += '<div class="form__errors">';
    html += '<p>Пожалуйста, исправьте следующие ошибки:</p>';
    html += '<ul>';
    errMsg.forEach(function(item, i, arr) {
        html += '<li>'+ item +'</li>';
    });
    html += '</ul>';
    html += '</div>';

    return html;
}

function createImageView(data){
    var html = '';

    for (var key in data) {
        html += '<li class="gif gif-list__item">';
        html += '<div class="gif__picture">';
        html += '<a href="/image/view?id='+ key + '" class="gif__preview" target="_blank">';
        html += '<img src="' + data[key] +'" alt="" width="260" height="260">';
        html += '</a>';
        html += '</div>';
        html += '</li>';
    }

    return html;
}

function clearInput(){
    $('#preview').val('');
}

function removeErrors(){
    $('div.form__errors').remove();
}

function hasInputFiles(){
    var result = true;
    var count = $('#preview').prop('files').length;
    if(count < 1 || count > maxCOuntFiles){
        var errMas = ['Кол-во файлов должно быть в диапазоне от 1 до ' + maxCOuntFiles ];
        var err = createErrorBlock(errMas);
        $('header.content__header').after(err);
        result = false;
    }
    return result;
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function checkMaxSize(){
    var result = true;
    var Lfiles = $('#preview').prop('files');
    var summ = 0;

    $.each(Lfiles, function(i, file) {
        summ += file.size;
    });

    if (summ > maxSize) {
        var errMas = ['максимальный размер файлов за 1 загрузку - ' + bytesToSize(maxSize) ];
        var err = createErrorBlock(errMas);
        $('header.content__header').after(err);
        result = false;
    }

    return result;
}