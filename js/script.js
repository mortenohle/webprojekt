$(document).ready(function () {

    // Shrinked Header

    var $document = $(document)

    $document.scroll(function() {
        if ($document.scrollTop() >= 60) {
            $('header').addClass('shrinked');
        } else {
            $('header').removeClass('shrinked');
        }
    });

});
