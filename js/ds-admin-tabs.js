/**
 * tabs of form in admin panel
 */
jQuery(document).ready(function($) {
    $("#form_tabs").tabs();
    $(".ds_download_table_csv").each(function(){
        $(".ds_download_table_csv").click(function(){
            //alert("clicked");
            $('table[class*=download_]').tableExport({type:'csv',escape:'false'});
        });
    });

});