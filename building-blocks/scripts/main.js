$(document).ready(function () {
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

