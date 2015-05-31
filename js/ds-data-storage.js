/**
 * organizing admin page elements
 */
jQuery(document).ready(function($){

   $(".field_ext").hide();
    $(".ghazale_ds_field_type").change(function(){
        var select = $(this).find("option:selected").text();
        switch (select){
            case"Drop Down":
                $(".field_ext").slideDown();
                break;
            case "Multiple Choice":
                $(".field_ext").slideDown();
                break;
            default:
                $(".field_ext").slideUp();

        }
        $(".field_ext").closest("div").find("input[type=text]").val("");

    });
    if($(".ghazale_ds_field_type").find("option:selected").text() == "Drop Down" || $(".ghazale_ds_field_type").find("option:selected").text() == "Multiple Choice" ){
        $(".field_ext").show();
    }

});