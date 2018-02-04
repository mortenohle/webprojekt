$(document).ready(function() {

    var ul = $("#main-slider ul");
    var slide_count = ul.children().length;
    var slide_width_pc = 100.0 / slide_count;
    var slide_index = 0;

    var first_slide = ul.find("li:first-child");
    var last_slide = ul.find("li:last-child");

    // Letzen Slide klonen und als erstes Listenelement verwenden
    last_slide.clone().prependTo(ul);

    // Ersten Slide klonen und als letztes Listenelement verwenden
    first_slide.clone().appendTo(ul);

    ul.find("li").each(function(indx) {
        var left_percent = (slide_width_pc * indx) + "%";
        $(this).css({"left":left_percent});
        $(this).css({width:(100 / slide_count) + "%"});
    });

    ul.css("margin-left", "-100%");

    // Prev Button
    $("#main-slider .prev").click(function() {
        console.log("prev button clicked");
        slide(slide_index - 1);
    });

    // Next Button
    $("#main-slider .next").click(function() {
        console.log("next button clicked");
        slide(slide_index + 1);
    });

    function slide(new_slide_index) {

        var margin_left_pc = (new_slide_index * (-100) - 100) + "%";

        ul.animate({"margin-left": margin_left_pc}, 400, function() {

            // Kommt der neue Slide vor dem ersten Slide
            if(new_slide_index < 0) {
                ul.css("margin-left", ((slide_count) * (-100)) + "%");
                new_slide_index = slide_count - 1;
            }
            // Kommt der neue Slide nach dem letzten Slide
            else if(new_slide_index >= slide_count) {
                ul.css("margin-left", "-100%");
                new_slide_index = 0;
            }

            slide_index = new_slide_index

        });

    }

});
