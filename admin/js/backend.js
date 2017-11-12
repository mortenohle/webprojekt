$(document).ready(function() {

    // File Upload Change Input Value
    $('#file').on('change', function (e) {
        var filename = e.target.value.split('\\').pop();
        $('.file-label').text(filename);
    });

});