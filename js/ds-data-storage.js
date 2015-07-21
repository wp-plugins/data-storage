/**
 * organizing admin page elements
 */
jQuery(document).ready(function($){

   $(".field_ext").hide();
    $(".ghazale_ds_field_type").change(function(){
        var select = $(this).find("option:selected").text();
        switch (select){
            case"Drop Down":
                $(".user_guide").slideUp();
                $(".field_ext").slideDown();
                $("#ghazale_ds_field_required").slideDown();
                break;
            case "Multiple Choice":
                $(".user_guide").slideUp();
                $(".field_ext").slideDown();
                $("#ghazale_ds_field_required").slideDown();
                break;
            case "Instruction Text":
                $("#ghazale_ds_field_required").slideUp();
                $(".field_ext").slideUp();
                $(".user_guide").slideDown().html("<i style='color: #47a447'>This field type is intended to give instructions to the user in certain parts of the form. (Example: Please write your surname in capital letters.)</i>");
                break;
            case "File Upload":
                $("#ghazale_ds_field_required").slideDown();
                $(".field_ext").slideUp();
                $(".user_guide").slideDown().html("<i style='color: #47a447'>The maximum allowed size for file upload depends on your server setting, and is not related to the plugin.</i>");
                break;
            default:
                $(".user_guide").slideUp();
                $("#ghazale_ds_field_required").slideDown();
                $(".field_ext").slideUp();
                break;

        }
        $(".field_ext").closest("div").find("input[type=text]").val("");

    });
    if($(".ghazale_ds_field_type").find("option:selected").text() == "Drop Down" || $(".ghazale_ds_field_type").find("option:selected").text() == "Multiple Choice" ){
        $(".field_ext").show();
    }

});