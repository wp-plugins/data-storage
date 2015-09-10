/**
 * download old table on button click
 */
jQuery(document).ready(function($) {
    $(".ds_download_old_table_csv").click(function(){
        //alert("clicked");
        $('#ds_old_table').tableExport({type:'csv',escape:'false'});
    });

    $(".div_show_hide_old_table").hide();
    $(".ds_show_hide_old_table").click(function(){
        $(".div_show_hide_old_table").slideToggle('slow');
    });
});