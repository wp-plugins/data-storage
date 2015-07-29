/**
 * clear file input
 */
jQuery(document).ready(function($){

    window.reset = function (e) {
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }
    $("input[class^=ds_reset_upload_field_]").click(function () {
        reset($('#'+$(this).attr('class')));
    });

});