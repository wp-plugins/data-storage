jQuery(document).ready(function($){

    $("#guide").css({"vertical-align":"top","border":"1px solid #CCCCCC","width":"90%","color":"#707070","word-wrap":"break-word"});
    $(".ghazaledb_type").each(function(index) {

        $(this).change(function () {
            var select = $(this).find("option:selected").text();
            switch (select) {
                case "Instruction Text":

                    $(".ghazaledb_field_required").eq(index).hide();
                    $(".multiple_choice").eq(index).hide();
                    $(".drop_down").eq(index).hide();
                    $(".ghazaledb_accept_upload").eq(index).hide();
                    break;
                case "Drop Down":
                    $(".drop_down").eq(index).show();
                    $(".multiple_choice").eq(index).hide();
                    $(".ghazaledb_field_required").eq(index).show();
                    $(".ghazaledb_accept_upload").eq(index).hide();
                    break;
                case "Multiple Choice":
                    $(".multiple_choice").eq(index).show();
                    $(".drop_down").eq(index).hide();
                    $(".ghazaledb_field_required").eq(index).show();
                    $(".ghazaledb_accept_upload").eq(index).hide();
                    break;
                case "File Upload":
                    $(".ghazaledb_accept_upload").eq(index).show();
                    $(".drop_down").eq(index).hide();
                    $(".multiple_choice").eq(index).hide();
                    break;
                default:
                    $(".ghazaledb_field_required").eq(index).show();
                    $(".drop_down").eq(index).hide();
                    $(".multiple_choice").eq(index).hide();
                    $(".ghazaledb_accept_upload").eq(index).hide();
                    break;
            }
        });

        var selected = $(this).find("option:selected").text();
        switch (selected) {
            case "Instruction Text":

                $(".ghazaledb_field_required").eq(index).hide();
                $(".drop_down").eq(index).hide();
                $(".multiple_choice").eq(index).hide();
                $(".ghazaledb_accept_upload").eq(index).hide();
                break;
            case "Drop Down":
                $(".drop_down").eq(index).show();
                $(".multiple_choice").eq(index).hide();
                $(".ghazaledb_field_required").eq(index).show();
                $(".ghazaledb_accept_upload").eq(index).hide();
                break;
            case "Multiple Choice":
                $(".multiple_choice").eq(index).show();
                $(".drop_down").eq(index).hide();
                $(".ghazaledb_field_required").eq(index).show();
                $(".ghazaledb_accept_upload").eq(index).hide();
                break;
            case "File Upload":
                $(".drop_down").eq(index).hide();
                $(".multiple_choice").eq(index).hide();
                $(".ghazaledb_accept_upload").eq(index).show();
                break;
            default :
                $(".drop_down").eq(index).hide();
                $(".multiple_choice").eq(index).hide();
                $(".ghazaledb_accept_upload").eq(index).hide();

                break;
        }
    });

    $(".overflow").css({"height":"300px","overflow":"scroll"});

    //$("#fields_table tr:nth-child(even)").css({"background":"#FFEBCC"});
    $("#fields_table tr:nth-child(odd)").css({"background":"#FFFFFF"});
    $("#fields_table").css({"border-collapse":"collapse","border":"1px solid #FF9900","margin-right":"50px"});
    $("#fields_table th").css({"background-color":"#FFFFFF","padding":"5px","text-align":"left"});
    $("#fields_table td").css({"padding":"5px"});


    $("#ghazaledb_deletion_checkbox").click(function(){
        var checkboxes = $(".ghazaledb_deletion_checkbox");
        checkboxes.prop("checked", !checkboxes.prop("checked"));

    });

    $(".select_bulk_action").change(function(){
        var bulk = $(this).find("option:selected").text();
        switch (bulk) {
            case "Bulk Delete":
                $(".bulk_action").click(function(){
                    var msg = confirm("Are you sure?\n(THIS ACTION CANNOT BE UNDONE)");
                    if(msg){

                    }else{
                        return false;
                    }
                });
        }
    });

    $("#accordion").accordion({heightStyle :"content"});

    $("#ghazaledb_confirm_email_user").click(function(){

        var confirmation_note = $("p[id=note]").html("<i>NOTE: Make sure you have selected <strong> Email </strong> as the Field Type when setting up the form. Otherwise the confirmation email wont be sent to user.</i>");
        if($("#ghazaledb_confirm_email_user").prop("checked")){
            confirmation_note.show();
        }else{
            confirmation_note.hide();
        }
    });

    $('#data_table').DataTable();
});