$(document).ready(function () {

    // Shrinked Header

    var $document = $(document)

    $document.scroll(function() {
        if ($document.scrollTop() >= 60) {
            $('header').addClass('shrinked');
            $('#search-input-wrapper').css('top', '61px');
        } else {
            $('header').removeClass('shrinked');
            $('#search-input-wrapper').css('top', '81px');
        }
    });

    // Search Toggle

    var search = $('.toggle-search');
    var searchInner = $('#search-input-wrapper');
    search.addClass('close');

    search.stop().click(function() {
        if(search.hasClass('close')) {
            searchInner.slideDown(300);
            search.removeClass('close');
            search.addClass('open');
            $('.search-desk #main-search').focus();
            $('.search-icon').attr('src', 'images/close.svg');
        } else {
            searchInner.slideUp(300);
            search.addClass('close');
            search.removeClass('open');
            $('.search-icon').attr('src', 'images/suche.svg');
        }
    });

    // Mobile Nav Toggle
    $('.mobile-menu-toggle').stop().click(function() {
        $('.nav-wrap').slideToggle(500);
        $(this).find('img').toggle();
    });

}); // End Document Ready
