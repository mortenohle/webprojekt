$(document).ready(function () {

    // Shrinked Header

    var $document = $(document);

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

    // Kundenkonto Menu Toggle
    $('.kundenkonto_menu_toggle').stop().click(function() {
        $('.menu_kundenkonto').slideToggle(500);
        $(this).toggleClass('open');
    });

    //reload page on change of select input
    $('#sortby').on('change', function() {
        document.getElementById("sort").submit();
    });

    $('#sizeis').on('change', function() {

        if ($.query.get('size').length) {
            var size = $.query.get('size');
            if (size) {
                size = this.options[this.selectedIndex].value
            }
            var newUrl = $.query.set('size', size);
            var oldurl = window.location.href.split('?')[0];

            window.location.href = oldurl + newUrl;

        } else {

            window.location.href = window.location.href +'&size='+this.options[this.selectedIndex].value
        }

    });




}); // End Document Ready
