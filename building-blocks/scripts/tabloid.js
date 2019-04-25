$(document).ready(function () {
    $('.tabloid_download').on('click', function (evt) {
        evt.preventDefault();
        convert_to_pdf();
    });
});

var printAll = function (evt, id) {

    evt.preventDefault();
    var data = {
        id: id,
        url: window.location.href
    };

    var url = window.location.href + "/printAll";

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (data) {
            $('#open-print-'+id).removeClass('disabled');
        }
    });
};

var convert_to_pdf = function () {
    console.log('convert to pdf');

    var $content_container = get_content();
    console.log($content_container.html());
    clean_html($content_container);

    var addImages = false;
    (addImages) ? convertImages($content_container) : postHtmlData(renderContent($content_container));
};

function postHtmlData(htmlContent) {
    $.post('building-blocks/php/save.php', {content: $(htmlContent).prop('outerHTML')})
        .done(function () {
            $('.tabloid_download').first().clone()[0].click();
        });
}

var get_content = function () {

    return $('<div>').append($('.block').clone());

    /*
    return ($('.nav-tabs').length != 0)
     ?
        $('<div>').append($('.desktop').find('.block').clone())
        :
        $('<div>').append($('.block').clone());
        */
};

function renderContent($page) {

    return $('<html>').append(
        $('<head>').append(
            $('<meta>').attr('charset', "UTF-8"),
            //html4 charset declaration
            $('<meta>').attr({'http-equiv': "Content-Type", content: "text/html; charset=UTF-8"}),
            $('<link>').attr({href: '../css/pdf.css', type: 'text/css', media: 'screen', rel: 'stylesheet'})
        ),
        $('<body>').append(
            $('<div>').addClass('pdf-container')
                .append(
                    $('<h1>').text($('#pdf-site-info').attr('root')),
                    $('<h2>').text($('#pdf-site-info').attr('page')),
                    $page.html()
                )
        )
    );
}

function convertImages($page) {

    var $images = $page.find('img');
    var total = $images.length;
    var processed = 0;

    $images.each(function () {
        var $img = $(this);
        var src = $img.attr('src');

        toDataURL(src, function (dataUrl) {
                processed++;
                $img.attr('src', dataUrl);
                if (processed >= total) {
                    postHtmlData(renderContent($page));
                }
            }
        )
    });

    if (total == 0) {
        postHtmlData(renderContent($page));
    }
}

function clean_html($el) {

    var elements = 'audio, .pagination-block, .you-tube-block, .video-block, .link-block';

    $el.find(elements).each(function () {
        $(this).remove();
    });

    return $el;
}

function toDataURL(src, callback, outputFormat) {
    var img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function () {
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
        var dataURL;
        canvas.height = this.naturalHeight;
        canvas.width = this.naturalWidth;
        ctx.drawImage(this, 0, 0);
        dataURL = canvas.toDataURL(outputFormat);
        callback(dataURL);
    };
    img.src = src;
    if (img.complete || img.complete === undefined) {
        img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
        img.src = src;
    }
}

