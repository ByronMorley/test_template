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
})(jQuery, window, document);