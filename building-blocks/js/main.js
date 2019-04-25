;(function ($, window, document, undefined) {

    // Baked-in settings for extension
    var defaults = {
        onInit: function () {
        }, // Func: User-defined, fires with slider initialisation
        onChange: function () {
        }, // Func: User-defined, fires with transition start
        afterChange: function () {
        }  // Func: User-defined, fires after transition end
    };

    var App = function (elem, settings) {
        this.paginationList = $(elem);
        this.liElems = this.paginationList.find('li');
        this.settings = $.extend({}, defaults, settings, $(elem).data('aqua-opts'));   // Obj: Merged user settings/defaults

        this.init();  // Call App initialisation method
    };

    // App object Prototype
    App.prototype = {
        init: function () {
            var _this = this;
            var links = [];
            this.settings['onInit']();

            this.addStartDots = false;
            this.addEndDots = false

            this.liElems.map(function () {
                links.push(new Link(this));
            });

            this.links = links;
            this.mutLinks = links;

            this.current = this.getCurrent();

            console.log(this.current);

            this.originalLength = this.links.length;
            this.setup();
            this.render(this.links);
        },
        setup: function () {
            var currentIndex = this.current.index;
            var _this = this;
            _this.links.map(function (link) {

                if (Math.abs(link.index - currentIndex) >= 2) {
                    if (link.index > 0 && link.index < _this.originalLength - 1) {
                        link.active = false;
                    }
                }
            });

            if (currentIndex > 2) {
                this.addStartDots = true;
            }
            if (currentIndex < this.links.length - 3) {
                this.addEndDots = true;
            }
        },
        getNextLink: function () {
            if (this.current.index == this.originalLength - 1) {
                return this.current.atag.href;
            } else {
                return this.mutLinks[this.current.index + 1].atag.href;
            }
        },
        getPrevLink: function () {
            if (this.current.index == 0) {
                return this.current.atag.href;
            } else {
                return this.mutLinks[this.current.index - 1].atag.href;
            }
        },
        nextLink: function () {
            return this.createLink('page-item', 'page-link', this.getNextLink(), '&#8594;')
        },
        prevLink: function () {
            return this.createLink('page-item', 'page-link', this.getPrevLink(), '&#8592;')
        },
        nextSectionLink: function () {
            return this.createLink('page-item', 'page-link', '', '&#8677;');
        },
        prevSectionLink: function () {
            return this.createLink('page-item', 'page-link', '', '&#8676;');
        },
        startDots: function (_this) {
            return _this.createLink('page-item start_dot', 'page-link', '', '...')
        },
        endDots: function (_this) {
            return _this.createLink('page-item end_dot', 'page-link', '', '...')
        },
        getCurrent: function () {
            var item;
            this.mutLinks.map(function (link) {
                if (link.selected) {
                    item = link;
                }
            });
            return item;
        },
        render: function (links) {
            var currentIndex = this.current.index;
            var _this = this;
            _this.paginationList.empty();

            _this.paginationList.append(_this.prevLink())

            var count = 0;

            links.map(function (link) {

                if (count == 1 && _this.addStartDots) {
                    _this.paginationList.append(_this.startDots(_this));
                }
                if (link.active) {
                    _this.paginationList.append(_this.renderLink(link))
                }
                if (count == links.length - 2 && _this.addEndDots) {
                    _this.paginationList.append(_this.endDots(_this));
                }
                count++;
            });
            _this.paginationList.append(_this.nextLink())
        },
        renderLink: function (link) {
            return $('<li>').addClass(link.className).append(
                $('<a>').addClass(link.atag.className).attr('href', link.atag.href).html(link.atag.innerHtml)
            )
        },
        createLink: function (linkClassName, aClassName, href, html) {
            return $('<li>').addClass(linkClassName).append(
                $('<a>').addClass(aClassName).attr('href', href).html(html)
            )
        }
    };

    var Link = function (elem) {
        this.classList = elem.classList;
        this.className = this.classList.value;
        this.selected = elem.classList.contains('active');
        this.atag = new ATag(elem.querySelector('a'));
        this.index = $(elem).index();
        this.active = true;
    }

    var ATag = function (elem) {
        this.className = elem.classList.value;
        this.href = elem.getAttribute('href');
        this.innerHtml = elem.innerHTML;
    }

    // jQuery plugin wrapper
    $.fn['paginator'] = function (settings) {
        return this.each(function () {
            // Check if already instantiated on this elem
            if (!$.data(this, 'paginator')) {
                // Instantiate & store elem + string
                $.data(this, 'paginator', new App(this, settings));
            }
        });
    }
})(jQuery, window, document);;;(function ($, doc, win) {
    "use strict";


    //--------------------------------------//
    //              GLOBALS
    //--------------------------------------//

    var name = 'hades_audio_player';
    var SERIAL = 477171;


    $.hades_audio_player = function (element, options, serial) {


        //--------------------------------------//
        //       DEFAULT PLUGIN SETTINGS
        //--------------------------------------//

        var defaults = {
            update_speed: 1000,
            solo: false,
            play_all: false,
        };

        //--------------------------------------//
        //       PLUGIN PRIVATE VARIABLES
        //--------------------------------------//

        var plugin = this; //use plugin instead of "this"
        //set unique ID for plugin instance
        var config;
        var id = "hades-audio-player-" + serial;

        var playing = false;

        var timer;

        /*------------ CONTROLS ---------*/

        var volume;
        var sound_on = true;

        /*------------ BUTTONS ---------*/

        var $play_pause_button;
        var $volume_button;


        /*---------OTHER ELEMENTS ---------*/

        var $volume_hover_pad;
        var $volume_meter;
        var $audio;
        var $source;
        var $audio_block_track;
        var $track_line;
        var $volume_track;
        var $volume_track_line;
        var $prev_track;
        var $next_track;
        var track;
        var tracks = [];
        var current_track;
        var audio_available = false;

        //--------------------------------------//
        //       CUSTOM SETTING SETUP
        //--------------------------------------//


        plugin.settings = {}; //initialise empty settings object

        var $element = $(element),  // reference to the jQuery version of DOM element the plugin is attached to
            element = element;        // reference to the actual DOM element

        //gather individual plugin defaults from the attr tags in the plugin element
        //example attribute: <div data-{plugin name}-opts='{"custom_variable":"value"}' />*
        var meta = $element.data(name + '-opts');


        //--------------------------------------//
        //              CONSTRUCTOR
        //--------------------------------------//

        plugin.init = function () {

            // the plugin's final properties are the merged default and user-provided options (if any)
            plugin.settings = $.extend({}, defaults, options, meta);
            config = plugin.settings;
            config.play_all = $element.attr('play');
            console.log("initialised plugin " + name + " -- " + serial);
            $element.attr('id', id);
            _create();

        };


        //--------------------------------------//
        //              PUBLIC METHODS
        //--------------------------------------//

        /**
         *  these methods can be called like:
         *  plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
         *  element.data('pluginName').publicMethod(arg1, arg2, ... argn) from outside the plugin, where "element"
         *  is the element the plugin is attached to;
         */

        plugin.stop_all = function () {
            if ($('.audio-block').length != 0) {
                $('.audio-block').each(function () {
                    if ($(this).data('hades_audio_player') != undefined) {
                        $(this).data('hades_audio_player').stop();
                    }
                });
            }
        };

        plugin.stop = function () {
            var $glyph = $play_pause_button.find('.glyphicon');
            swap_glyphs($glyph, 'glyphicon-pause', 'glyphicon-play');
            _pause();

        };

        plugin.play_pause = function ($button) {
            if (audio_available) {
                _play_pause_toggle($button);
            }
        };

        plugin.volume = function ($button) {
            if (audio_available) {
                _toggle_volume_on_and_off($button);
            }
        };


        //--------------------------------------//
        //              PRIVATE METHODS
        //--------------------------------------//
        /**
         *  these methods can be called only from inside the plugin like:
         *  methodName(arg1, arg2, ... argn)
         */

        var _create = function () {
            _setup_variables();
            if (audio_available) {
                _bind_events();
                _setup_layout();
            }
        };

        var _update = function () {

            if (track.currentTime >= track.duration) {
                if (current_track.id == tracks.length - 1) {
                    _reset_track();
                }else{
                    if (config.play_all) {
                        var new_id;
                        plugin.stop_all();
                        new_id = current_track.id + 1;
                        go_to_track(new_id);
                    } else {
                        _reset_track();
                    }
                }

            } else {
                _update_track_line(track.currentTime);
            }

        };

        var _bind_events = function () {
            $volume_hover_pad.volume_hover();
            $volume_meter.volume_hover();
            $volume_button.volume_hover();
            $play_pause_button.button_click();
            $volume_button.button_click();
            $volume_track.vertical_track();
            $audio_block_track.horizontal_track();
            $prev_track.change_track();
            $next_track.change_track();
        };

        var _setup_layout = function () {
            hide_and_show_arrows();
            set_volume_meter_position();
        };

        var _setup_variables = function () {

            load_tracks();

            $volume_hover_pad = $element.find('.audio-block-volume-hover-pad');
            $volume_meter = $element.find('.audio-block-volume-meter');
            $volume_button = $element.find('.audio-block-volume-button');
            $play_pause_button = $element.find('.audio-block-play');

            $audio_block_track = $element.find('.audio-block-track');
            $track_line = $element.find('.audio-block-track-line');
            $volume_track = $element.find('.audio-block-volume-track');
            $volume_track_line = $element.find('.audio-block-volume-track-line');

            $prev_track = $element.find('.glyphicon-step-backward');
            $next_track = $element.find('.glyphicon-step-forward');

        };

        var load_tracks = function () {

            if (plugin.settings.solo) {
                audio_available = true;
                set_current_track(Track(0, $element.find('source').attr('src'), false, false));
            } else {

                var $audio_blocks = $element.find('.audio-text');
                $audio_blocks.each(function (index) {

                    var $a_block = $(this);
                    var source = $a_block.find('source').attr('src');
                    var avatar = $a_block.attr('avatar');
                    tracks.push(Track(index, $a_block.find('source').attr('src'), false, (avatar.length == 0) ? false : avatar));
                });

                if (tracks.length > 0) {
                    console.log((tracks.length + 1) + ' audio files found');
                    audio_available = true;
                    set_current_track(tracks[0])
                } else {
                    console.log('no audio found');
                    audio_available = false;
                }
            }
        };

        var hide_and_show_arrows = function () {

            $next_track.show();
            $prev_track.show();
            if (current_track.id == 0) {
                $prev_track.hide();
            }
            if (current_track.id == tracks.length - 1) {
                $next_track.hide();
            }
        };

        var set_current_track = function (a_track) {

            current_track = a_track;

            for (var a = 0; a < tracks.length; a++) {
                tracks[a].current = false;
                console.log(tracks[a].avatar);
            }
            a_track.current = true;
            if (a_track.avatar != false) {
                set_avatar(a_track);
            }
            track = new Audio(a_track.src);
        };


        var set_avatar = function (a_track) {

            var $av_wrapper = $element.find('.bottom-wrapper');
            $av_wrapper.find('.avatar').remove();
            $av_wrapper.prepend(
                $('<div>').addClass('avatar col-md-6 col-xs-12 ' + a_track.alignment).append(
                    $('<img>').attr('src', a_track.avatar)
                ));
        };

        var _update_track_line = function (time) {

            var position = (time / track.duration ) * 100;
            /*
             console.log("track.duration " + track.duration);
             console.log("time " + time);
             console.log("position " + position);
             */
            if (position > 100) {
                $track_line.css('width', "100%");
            } else {
                $track_line.css('width', position + "%");
            }
        };

        var _reset_track = function () {

            track.currentTime = 0;
            _update_track_line(0);
            _pause();
            swap_glyphs($play_pause_button.find('.glyphicon'), 'glyphicon-pause', 'glyphicon-play');
        };

        var _toggle_volume_on_and_off = function ($button) {

            var $glyph = $button.find('.glyphicon');

            if (sound_on) {
                sound_on = false;
                swap_glyphs($glyph, 'glyphicon-volume-up', 'glyphicon-volume-off');
                _volume_off();
            } else {
                sound_on = true;
                swap_glyphs($glyph, 'glyphicon-volume-off', 'glyphicon-volume-up');
                _volume_on();
            }
        };

        var _play_pause_toggle = function ($button) {

            var $glyph = $button.find('.glyphicon');

            if (playing) {
                swap_glyphs($glyph, 'glyphicon-pause', 'glyphicon-play');
                _pause();
            } else {
                plugin.stop_all();
                swap_glyphs($glyph, 'glyphicon-play', 'glyphicon-pause');
                _play();
            }
        };

        var set_track_position = function (position) {

            track.currentTime = track.duration * position;
            _update();

        };

        var update_volume = function () {

            var position = track.volume * 100;
            $volume_track_line.css('height', position + "%");
        };

        var time_interval = function () {

            return setInterval(function () {
                _update();
            }, config.update_speed);
        };

        var go_to_track = function (id) {

            var $glyph = $play_pause_button.find('.glyphicon');
            swap_glyphs($glyph, 'glyphicon-pause', 'glyphicon-play');
            _pause();
            set_current_track(tracks[id]);
            hide_and_show_arrows();
            var $audio_text = $element.find('.audio-text');
            $audio_text.removeClass('current');
            $audio_text.eq(id).addClass('current');
            swap_glyphs($glyph, 'glyphicon-play', 'glyphicon-pause');
            _play();
        };

        //--------------------------------------//
        //    BASIC CONTROLS
        //--------------------------------------//

        var _play = function () {
            playing = true;
            track.play();
            timer = time_interval();
        };
        var _pause = function () {
            playing = false;
            track.pause();
            clearInterval(timer);
        };
        var _volume_off = function () {
            volume = track.volume;
            track.volume = 0;
            update_volume();
        };
        var _volume_on = function () {
            track.volume = volume;
            update_volume();
        };
        var set_volume = function (volume) {
            sound_on = (volume > 0);
            track.volume = volume;
            update_volume();
        };

        var _next = function () {

        };
        var _prev = function () {

        };


        //--------------------------------------//
        //    OBJECTS
        //--------------------------------------//


        var Track = function (id, src, current, avatar) {
            id = parseInt(id);
            var alignment = (id % 2) ? "right" : "left";
            return {
                id: id,
                src: src,
                current: current,
                avatar: avatar,
                alignment: alignment
            }

        };


        //--------------------------------------//
        //    HELPER FUNCTIONS
        //--------------------------------------//


        var set_volume_meter_position = function () {

            var offset = (($volume_button.width() / 2) + 15) - ($volume_meter.width() / 2);
            $volume_meter.css('margin-right', offset + 'px');
        };

        var swap_glyphs = function ($glyph, old_glyph, new_glyph) {
            $glyph.removeClass(old_glyph);
            $glyph.addClass(new_glyph);
        };


        //--------------------------------------//
        //    CUSTOM BINDING EVENTS
        //--------------------------------------//

        /**
         *    Add custom methods to selectors
         *    These are called by adding the function to the selectors
         *    eg: $('.element).bind_event(args);
         */

        $.fn.change_track = function () {
            $(this).each(function () {
                $(this).on('click', function () {
                    var new_id;
                    plugin.stop_all();
                    if ($(this).hasClass('glyphicon-step-backward')) {

                        console.log('back');
                        new_id = current_track.id - 1;
                        go_to_track(new_id);
                    }
                    if ($(this).hasClass('glyphicon-step-forward')) {

                        console.log('forward');
                        new_id = current_track.id + 1;
                        go_to_track(new_id);
                    }
                });
            });
        };

        $.fn.volume_hover = function () {

            $(this).each(function () {
                $(this)
                    .on('mouseover', function () {
                        $element.find('.audio-block-volume-meter').show();
                    })
                    .on('mouseleave', function () {
                        $element.find('.audio-block-volume-meter').hide();
                    });
            });
        };

        $.fn.button_click = function () {

            $(this).on('click', function () {
                var call = $(this).attr('action');
                $('#' + id).data('hades_audio_player')[call]($(this));
            });
        };


        $.fn.vertical_track = function () {

            $(this).on('click', function (e) {

                var offset = $(this).offset();
                var click_position = e.pageY - offset.top;
                var position = 1 - (click_position / $(this).height());
                position = (position > 0.9) ? 1 : position;
                position = (position < 0.1) ? 0 : position;
                set_volume(position);
            });

        };

        $.fn.horizontal_track = function () {

            $(this).on('click', function (e) {

                var offset = $(this).offset();
                var click_position = e.pageX - offset.left;
                var position = click_position / $(this).width();
                set_track_position(position);
            });

        };


        $(window).on('resize', function () {
            set_volume_meter_position();
        });

        //-----------------------------------------
        //				INITIALISATION
        //-----------------------------------------

        plugin.init();

    };


    //-----------------------------------------
    //				INVOCATION
    //-----------------------------------------

    /**
     *  element.data('pluginName').publicMethod(arg1, arg2, ... argn) or
     *  element.data('pluginName').settings.propertyName
     *
     */

    $.fn.hades_audio_player = function (options) {
        return this.each(function () {
            if (undefined == $(this).data(name)) {
                var plugin = new $.hades_audio_player(this, options, SERIAL++);
                $(this).data(name, plugin);
            }
        });
    };
})(jQuery, document, window);;$(document).ready(function () {
    $('.tab-block').each(function () {
        checkNavTabs($(this));
    });

    $('.nav-link').on('click', function () {
        localStorage.setItem('tabs', $(this).parent().index());
    });

    /*
    $('.pagination').twbsPagination({
        totalPages: 18,
        visiblePages: 5,
        first: '&laquo;',
        prev: '<',
        next: '>',
        last: '&raquo;',
        anchorClass: 'page-link',
        href: true,
    });
    */

});

function checkNavTabs($block) {

    var $tabs = $block.find('.nav-link');
    var $panes = $block.find('.tab-pane');

    if (localStorage.getItem('tabs') === null) {
        console.log('null');
        $tabs.first().addClass('show active');
        $panes.first().addClass('show active');
        localStorage.setItem('tabs', 0);

    } else {

        var index = localStorage.getItem('tabs');

        console.log(index);
        var $tab = $tabs.eq(index);
        $tab.addClass('show active');
        $($tab.attr('href')).addClass('show active');
    }
}

;$(document).ready(function () {
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

