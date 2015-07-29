/**
 * tabs of form in admin panel
 */
jQuery(document).ready(function($) {
    $("#form_tabs").tabs();
        $("input[class^=ds_download_table_csv_]").click(function(){
            //alert("clicked");
            var currentTable = $('#'+$(this).attr('class'));
            currentTable.tableExport({type:'csv',escape:'false',tableName:'yourTableName'});

        });

});