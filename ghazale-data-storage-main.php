<?php
/*
Plugin Name: Data Storage
Plugin URI: http://ghazale.co.nf/data-storage-version-2-1-1-is-released/
Description: Fully customizable,editable,downloadable data table creator. You can have multiple different forms and their corresponding tables in one wordpress system. Equipped with instant feedback to user upon submitting the form. Perfect for collecting people's data, information, inquiries and many other purposes such as online contests. In addition of having the data in the backend, you also have the option to receive the details of the submitted data, right in your email as well. There's also the option to send Thank you/Confirmation email to the user with customized text and address as well as many other cool features.
Author: Ghazale Shirazi
Version: 2.1.1
Author URI: http://ghazale.co.nf


    Copyright 2015  Ghazale Shirazi  (email : ghsh88@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
require_once("ghazale-ds-message-session.php");
/**
 * welcome and guide page
 */
function ghazale_ds_welcome_page(){
    $field_count = 20;
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    $sql = 'SELECT * FROM ' . $table_name . ' ORDER BY id ASC';
    $results = $wpdb->get_results($sql, ARRAY_A);
    ?>
    <h2>Welcome to Data Storage (v2.1.1)</h2>
    <?php
    if($results) {
        ?>
        <h3>Your Old Table</h3>
        <div style="border: 1px solid #404040; padding: 10px">If you previously had the old version of Data Storage, your old data is still safe. You can view or download it here.
        <br><i>It is recommended to use the new version of Data Storage as it has more security, more flexibility, more stability, and ability to have multiple forms (and tables).</i></br></div>
        <p><input type="button" class="ds_show_hide_old_table" value="Show My Old Table" style="background-color: #404040; border: #404040; color: #ffffff; cursor: pointer" /></p>
        <hr>
        <div class="div_show_hide_old_table">
        <p><input type="button" name="ds_download_old_table_csv" class="ds_download_old_table_csv" value="Download Table In CSV Format" /><i> After you downloaded the table, rename the file and put <strong>".csv"</strong> at the end of the file name to be able to open it in excel.</i></p>
            <p><a href="<?php echo get_admin_url(); ?>admin.php?page=ds-data-storage&ds-old-data-table=ds-totally-delete-old-data-table" style="text-decoration: none" onclick="return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)')"><input type="button" value="Totally Delete This Old Table. I Don't Need It" /></a><i> You can totally delete this table if you don't want it anymore</i></p>
        <table id="ds_old_table" class="table">
            <thead>
            <tr>

                <?php
                for ($count = 1; $count <= $field_count; $count++) {
                    if (trim(get_option("ghazaledb_field_{$count}")) != "") {

                        if ((get_option("ghazaledb_field_{$count}"))) {
                            if ($count == 1) {
                                ?>
                                <th>ID</th>
                                <th>Date|Time</th>

                            <?php
                            }
                            ?>
                            <th>
                            <?php
                            if (get_option("ghazaledb_type_{$count}") != "Instruction Text{$count}") {
                                echo esc_attr(get_option("ghazaledb_field_{$count}"));
                            }
                        }
                        ?>
                        </th>
                    <?php
                    } else {
                        echo "<th></th>";
                    }
                }

                ?>
            </tr>
            </thead>
            <tbody>

            <?php

            foreach ($results as $result) {

                ?>
                <tr>
                    <?php
                    foreach ($result as $key => $value) {

                        if (trim($value) != "") {
                            if (substr($value, 0, 4) === "http") {
                                echo "<td><a href='" . $value . "' target='_blank'>" . $value . "</a> </td>";
                            } else {
                                echo "<td>{$value}</td>";
                            }
                        } else {
                            echo "<td></td>";
                        }
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
    <?php
    }
    ?>
    <p><strong>The shortcode in the new version of Data Storage has changed to have dynamic attribute which lets you to have multiple (and unlimited!) different forms at the same time.</strong></p>
    <div style="color:#ffffff ;background-color:#47a447 ; padding: 10px"><strong>As soon as you create a new form and add form fields to your newly created form, you will see the automatically generated shortcode for the corresponding form in the "Forms" section under "Data Storage" menu. So you don't have to memorize any shortcode. It's always there for your reference for all of your forms.</strong></div>
    <hr>
    <h3>Making Your First Form</h3>
    <p>To make a new form, follow these steps:</p>
    <ol>
        <li>Click on "Create New Form" menu. Name your new form and create it.</li>
        <li>Click on "Add Fields" menu. Select your newly created form, name your field and choose field type (e.g.: Text Input, Checkbox, DropDown, etc). You can also choose whether you want this field to be "Required" or not.</li>
        <li>Repeat number 2 and add as much as fields you like! (You can add unlimited number of fields to your form)</li>
        <li>Your form is ready to use! Click on "Form" menu. You can see the automatically generated shortcode for this form to use on any post or page. You can also edit or delete any of the form fields here.</li>
        <li>Enjoy!</li>

    </ol>
    <h3>Having Your First Inputs</h3>
    <p>Once you put the shorcode of your created form on your desired page, you can see the awesome form that you've just made. When this form is filled with data and gets submitted, you can see the inserted data in the backend of your site in "Inputs" section under "Data Storage" menu.</p>
    <hr>
    <h3>General Settings</h3>
    <p>In the "General Settings" tab, I've put many options:</p>
    <ol>
        <li>You can have Captcha on your forms to fight against spams and robots.</li>
        <li>You can change the word on "Submit" button.</li>
        <li>You can choose to update admin when there is a new form submission.</li>
        <li>You can choose to send confirmation email to user with custom message.</li>
        <li>You can have a custom page redirection upon form submission</li>
        <i>Even if you don't wish to redirect user to another page, the plugin will handle the feedback for the user. So they realize that their entry has been successfully submitted.</i>
    </ol>
    <hr>
    <div style="color:#707070; background-color: #cccccc ; border: 1px solid #cccccc; padding: 10px">If you ever had questions, suggestions or comments feel free to express yourself on support forum or <a href="mailto:ghsh88@gmail.com">drop me a line</a> :)</div>
    <?php
}
function ghazale_ds_welcome_page_admin_menu(){
    $page_suffix = add_menu_page('Data Storage','Data Storage','manage_options','ds-data-storage','ghazale_ds_welcome_page', plugin_dir_url(__FILE__) . 'images/ic_data_storage.png');
    add_submenu_page('ds-data-storage','Welcome','Welcome','manage_options','ds-data-storage','ghazale_ds_welcome_page');
    add_action('admin_print_scripts-'.$page_suffix,'ghazale_ds_download_old_table');
}
add_action('admin_menu','ghazale_ds_welcome_page_admin_menu');
function ghazale_ds_download_old_table(){
    wp_enqueue_script('ghazale-ds-button-click-download');
    wp_enqueue_script('ghazale-ds-table-export');
    wp_enqueue_script('ghazale-ds-jquery-base64');
    wp_enqueue_style('ghazale-ds-old-table-style');
}
function ghazale_ds_download_old_table_script(){
    wp_register_script('ghazale-ds-button-click-download', plugins_url('js/ds-download-old-table.js',__FILE__),array('jquery'));
    wp_register_script('ghazale-ds-table-export', plugins_url('js/tableExport.js',__FILE__),array('jquery'));
    wp_register_script('ghazale-ds-jquery-base64',plugins_url('js/jquery.base64.js',__FILE__),array('jquery'));
    wp_register_style('ghazale-ds-old-table-style', plugins_url('css/ds-table-style.css',__FILE__));
}
add_action('admin_init','ghazale_ds_download_old_table_script');

/**
 * delete old data table if exists (upon admin request)
 */
function ghazale_ds_totally_delete_old_data_table(){
 if(isset($_GET['ds-old-data-table']) && $_GET['ds-old-data-table'] == 'ds-totally-delete-old-data-table'){
     global $wpdb;
     $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ghazaledb");
     $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'ghazaledb_%'" );
 }
}
add_action('init','ghazale_ds_totally_delete_old_data_table');

/**
 * admin page for creating new form
 */

function ghazale_ds_new_form(){
    ?>
    <div xmlns="http://www.w3.org/1999/html"><?php echo ghazale_ds_message(); ?></div>
    <form action="" method="post" id="ghazale_ds_new_form">
        <h2>Create New Form</h2>
        Form Name: <input type="text" name="ghazale_ds_new_form_name" id="ghazale_ds_new_form_name" value="<?php echo $_POST['ghazale_ds_new_form_name']; ?>"/><i> Please enter letters and numbers only. No spaces.</i>
        <br><br><input type="submit" name="ghazale_ds_submit_new_form" value="Create Form">
    </form>
<?php
}
function ghazale_ds_new_form_admin_menu(){
    add_submenu_page('ds-data-storage','Create New Form','Create New Form','manage_options','ds-create-new-form','ghazale_ds_new_form');
}
add_action('admin_menu','ghazale_ds_new_form_admin_menu');

/**
 * creates 2 relational tables upon admin request
 */
function ghazale_ds_create_tables(){
    if($_POST['ghazale_ds_submit_new_form']) {
        if (ctype_alnum(trim($_POST['ghazale_ds_new_form_name']))) {
            global $wpdb;
            $table_name = $wpdb->prefix . "ghazale_ds_" . strtolower(trim($_POST['ghazale_ds_new_form_name']));
            $tables= $wpdb->get_results("SHOW TABLES LIKE "."'" .$table_name."%'");
            if (count($tables)== 0) {
                $sql_form = "CREATE TABLE " . $table_name . "_fields (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_required VARCHAR (8) COLLATE ascii_bin, PRIMARY KEY (id))";
                $wpdb->query($sql_form);
                $sql_input = "CREATE TABLE " . $table_name . "_inputs (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_id INTEGER(10), field_input VARCHAR(3000) COLLATE utf8_bin, PRIMARY KEY (id))";
                $wpdb->query($sql_input);
                $_SESSION['ds-message'] = "Form Created Successfully";
            } else {
                $_SESSION['ds-message'] = "That name already exists";
            }

        } else {
            $_SESSION['ds-message'] = "The form name SHOULD be alphanumeric. Please enter a valid name";
        }
    }
}
add_action('wp_loaded','ghazale_ds_create_tables');

/**
 * admin page for adding fields to the selected form
 */

function ghazale_ds_add_fields(){
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazale_ds_";
    $tables= $wpdb->get_results("SHOW TABLES LIKE "."'" .$table_name."%_fields'",ARRAY_A);
    ?>
    <form action="" method="post" id="ghazale_ds_add_fields">
        <div><?php echo ghazale_ds_message(); ?></div>
        <h2>Add Fields To The Form</h2>
        <p>Add fields to your forms as much as you like!</p>
        Select Form : <select name="ghazale_ds_select_form">
            <option value=""> -- Select Form -- </option>
            <?php
            foreach($tables as $table){
                foreach ($table as $select_table) {
                    echo "<option value='" . $select_table ."'" ;
                    if($_POST['ghazale_ds_select_form'] == $select_table){
                        echo " selected";
                    }
                    echo ">" . ucfirst(str_replace(array($table_name,'_fields'),'',$select_table)) . "</option>";
                }
            }
            ?>
        </select><i> Select the form to which you want to add the field</i><br><br>
        Field Name: <input type="text" name="ghazale_ds_field_name" id="ghazale_ds_field_name" maxlength="300" placeholder="Enter Field Name" value="<?php echo $_POST['ghazale_ds_field_name']; ?>"/><i> Example: Name, Email, Address, etc... (Should be alphanumeric)</i><br><br>
        <?php $type_array = array("Text Field","Text Area","Drop Down","Multiple Choice","Email","File Upload","Number","Telephone","URL","Date","CheckBox","Instruction Text"); ?>
        Field Type: <select name="ghazale_ds_field_type" class="ghazale_ds_field_type">
            <option value=""> -- Select Field Type -- </option>
            <?php
            foreach($type_array as $type){
                echo "<option value='" . $type . "'" ;
                if($_POST['ghazale_ds_field_type'] == $type){
                    echo " selected";
                }
                echo ">" . $type ."</option>";
            }
            ?>
        </select><i> Select the field type</i><br><br>
        <input type="checkbox" name="ghazale_ds_field_required" value="Required"/> Required Field <i> ( required fields will be marked by * in the form )</i><br><br>
        <div class="field_ext">
            <i>You can have up to 10 values for this field :</i><br>
            <?php
            for($i=0;$i<=9;$i++){
                echo "<input type=\"text\" name=\"field_ext_".$i."\" value=\"". $_POST["field_ext_{$i}"] ."\" /><br>";
            }
            ?>
        </div>

        <br><input type="submit" name="ghazale-ds-submit-field-name" value="Add Field">
    </form>
<?php
}

function ghazale_ds_add_fields_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage','Add Fields','Add Fields','manage_options','ds-add-field','ghazale_ds_add_fields');
    add_action('admin_print_scripts-' . $page_suffix, 'ghazale_ds_admin_field_ext');
}
add_action('admin_menu','ghazale_ds_add_fields_admin_menu');

function ghazale_ds_admin_field_ext(){
    wp_enqueue_script('ds-field-ext');

}
function ghzale_ds_admin_init_field_ext(){
    wp_register_script('ds-field-ext',plugins_url('js/ds-data-storage.js',__FILE__),array('jquery'));

}
add_action('admin_init','ghzale_ds_admin_init_field_ext');

/**
 * register settings
 */

function ghazale_ds_register_settings(){
    register_setting('ghazale_ds_settings','ghazale_ds_add_captcha');
    register_setting('ghazale_ds_settings', 'ghazale_ds_custom_captcha_msg');
    register_setting('ghazale_ds_settings','ghazale_ds_page_redirection');
    register_setting('ghazale_ds_settings','ghazale_ds_confirmation_email');
    register_setting('ghazale_ds_settings','ghazale_ds_confirmation_from');
    register_setting('ghazale_ds_settings','ghazale_ds_confirmation_msg');
    register_setting('ghazale_ds_settings','ghazale_ds_update_admin');
    register_setting('ghazale_ds_settings','ghazale_ds_update_admin_email');
}
add_action('admin_init','ghazale_ds_register_settings');

/**
 * @param $string
 * @return mixed
 * sanitizing input before they get inserted to db
 */

function alphanumericAndSpace( $string )
{
    return !preg_match('/[^\w\p{L}\p{N}\p{Pd} @-_.,\/:()]/u', $string);
}


/**
 * add fields to the selected form
 */
function ghazale_ds_add_fields_to_table(){
    if(isset($_POST['ghazale-ds-submit-field-name'])) {
        $output ="";
        for ($i = 0; $i <= 9; $i++) {
            if (alphanumericAndSpace($_POST["field_ext_{$i}"]) && trim($_POST["field_ext_{$i}"] !="")){
                $output .= trim($_POST["field_ext_{$i}"]) . " | ";
            }
        }
        if (!empty($_POST['ghazale_ds_select_form']) && alphanumericAndSpace($_POST['ghazale_ds_field_name']) && trim($_POST['ghazale_ds_field_name']) !="" && !empty($_POST['ghazale_ds_field_type'])) {
            global $wpdb;
            if(!empty($output)){
                $wpdb->insert($_POST['ghazale_ds_select_form'], array('field_name' => stripcslashes(trim($_POST['ghazale_ds_field_name'])), 'field_type' => $_POST['ghazale_ds_field_type'], 'field_ext'=> $output , 'field_required'=> $_POST['ghazale_ds_field_required']), array('%s'));
                $_SESSION['ds-message'] = "Field Added Successfully";
            }else {
                $wpdb->insert($_POST['ghazale_ds_select_form'], array('field_name' => stripcslashes(trim($_POST['ghazale_ds_field_name'])), 'field_type' => $_POST['ghazale_ds_field_type'],'field_required'=> $_POST['ghazale_ds_field_required']), array('%s'));
                $_SESSION['ds-message'] = "Field Added Successfully";
            }
        }else{
            $_SESSION['ds-message'] = "All fields are required. Please make sure you have filled all fields (Also make sure the entered Field Name is not containing symbols)";
        }
    }

}
add_action('init','ghazale_ds_add_fields_to_table');

/**
 * showing forms in the backend with the ability to edit or delete any form
 */

function ghazale_ds_created_forms(){
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazale_ds_";
    $sql = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
    $tables = $wpdb->get_results($sql,ARRAY_A);
    echo ghazale_ds_message();
    if(!empty($tables)) {
        echo "<div id=\"form_tabs\">";
        echo "<ul>";
        foreach ($tables as $table) {
            foreach ($table as $fields_table) {
                echo "<li><a href=\"#". $fields_table ."\">" . ucfirst(str_replace(array($table_name,'_fields'),'',$fields_table)) . "</a></li>";
            }
        }
        echo "</ul>";
        foreach ($tables as $table) {
            foreach ($table as $fields_table) {
                $sql_fields = "SELECT * FROM {$fields_table}";
                $fields_query= $wpdb->get_results($sql_fields, ARRAY_A);
                echo "<div id=\"". $fields_table ."\">";
                if (!empty($fields_query)) {
                    echo "<h2>". ucfirst(str_replace(array($table_name,'_fields'),'',$fields_table)) ."</h2>";
                    echo "<p>Shortcode : <strong>[data-storage form=\"". str_replace(array($table_name,'_fields'),'',$fields_table) . "\"]</strong></p>";
                    echo "<table class=\"table\"><tr><th>Delete</th><th>Edit</th><th>Field Name</th><th>Field Type</th><th>Extensions</th><th>Required</th></tr>";
                    foreach($fields_query as $fields){
                        echo "<tr>";
                        echo "<td><a href='". get_admin_url() ."admin.php?page=ds-forms&ds-del-field-id=".$fields['id'] ."&ds-del-field-table=". $fields_table."' style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"Delete\"></a> </td>";
                        echo "<td><a href='". get_admin_url() ."admin.php?page=ds-edit-field&ds-edit-field-id=".$fields['id'] ."&ds-edit-field-table=". $fields_table."' style=\"text-decoration: none\" ><input type=\"button\" value=\"Edit\"></a> </td>";
                        echo "<td>" . $fields['field_name'] . "</td>";
                        echo "<td>" . $fields['field_type'] . "</td>";
                        echo "<td>" . $fields['field_ext'] . "</td>";
                        echo "<td>" . $fields['field_required'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table><br>";

                }else{
                    echo "<br>There are no fields for this form yet. <a href=\"".get_admin_url() ."admin.php?page=ds-add-field\"> Add fields</a> to this form<br><br>";
                }
                echo "<a href=\"".get_admin_url() ."admin.php?page=ds-forms&ds-total-del-form-table=". $fields_table ."\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\" ><input type=\"button\" value=\"Totally Delete This Form AND Its Corresponding Inputs Table\"></a>";
                echo "</div>";
            }
        }
    }else{
        echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"><strong>No form(s) to display. Please Create a new form first. Once you create your first form and add fields to it, it will appear on this page in an organized table.</strong></div>";
    }
    echo "</div>";

}
function ghazale_ds_created_tables_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage','Forms','Forms','manage_options','ds-forms','ghazale_ds_created_forms');
    add_action('admin_print_scripts-' . $page_suffix, 'ghazale_ds_admin_form_table_tabs');
}
add_action('admin_menu','ghazale_ds_created_tables_admin_menu');

function ghazale_ds_admin_form_table_tabs(){
    wp_enqueue_style('ds-tabs-style');
    wp_enqueue_style('ds-table-style');
    wp_enqueue_script('ds-tabs-script');
}

function ghazale_ds_admin_form_table_tabs_register(){
    wp_register_style('ds-tabs-style',plugins_url('css/jquery-ui.min.css',__FILE__));
    wp_register_style('ds-table-style', plugins_url('css/ds-table-style.css',__FILE__));
    wp_register_script('ds-tabs-script', plugins_url('js/ds-admin-tabs.js',__FILE__),array('jquery','jquery-ui-core','jquery-ui-tabs'));
}
add_action('admin_init','ghazale_ds_admin_form_table_tabs_register');

/**
 * delete selected form table
 */
function ghazale_ds_totally_delete_form_table(){
    if(isset($_GET['ds-total-del-form-table']) && $_GET['page'] == 'ds-forms'){
        global $wpdb;
        $table_name = $wpdb->prefix . "ghazale_ds_";
        $sql = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
        $tables = $wpdb->get_results($sql,ARRAY_A);
        foreach ($tables as $table) {
            foreach ($table as $fields_table) {
                if($fields_table == $_GET['ds-total-del-form-table']){
                    $wpdb->query("DROP TABLE IF EXISTS ". $fields_table);
                    $_SESSION['ds-message'] = "Deleted Successfully";
                }
            }
        }
        $sql_inputs = "SHOW TABLES LIKE '" . $table_name . "%_inputs'";
        $input_tables = $wpdb->get_results($sql_inputs, ARRAY_A);
        $entry_table = str_replace("_fields","_inputs",$_GET['ds-total-del-form-table']);
        foreach($input_tables as $input_table){
            foreach($input_table as $inputs){
                if($inputs == $entry_table){
                    $wpdb->query("DROP TABLE IF EXISTS ". $inputs);
                    $_SESSION['ds-message'] = "Deleted Successfully";
                }
            }
        }
    }
}
add_action('init','ghazale_ds_totally_delete_form_table');

/**
 * edit page for editing the fields that are already added
 */

function ghazale_ds_edit_field_admin_page(){
    global $wpdb;
    $db_table_name = $wpdb->prefix . "ghazale_ds_";
    $id = $_GET['ds-edit-field-id'];
    $table = $_GET['ds-edit-field-table'];
    $sql = "SELECT * FROM {$table} WHERE id={$id}";
    $field = $wpdb->get_row ($sql, ARRAY_A);
    ?>
    <h2>Edit Field</h2>
    <?php echo ghazale_ds_message(); ?>
    <form action="" method="post" id="ghazale_ds_edit_field">
        <h4>Form : <?php echo ucfirst(str_replace(array($db_table_name, "_fields"),"", $_GET['ds-edit-field-table'])); ?> </h4>
        Field Name : <input type="tex" name="ghazale_ds_edit_field_name" id="ghazale_ds_edit_field_name" value="<?php echo $field['field_name']; ?>"/><i> Should be alphanumeric. Can have space.</i><br><br>
        <?php $type_array = array("Text Field","Text Area","Drop Down","Multiple Choice","Email","File Upload","Number","Telephone","URL","Date","CheckBox","Instruction Text"); ?>
        Field Type: <select name="ghazale_ds_edit_field_type" class="ghazale_ds_field_type">
            <option value=""> -- Select Field Type -- </option>
            <?php
            foreach($type_array as $type){
                echo "<option value='" . $type . "'" ;
                if($field['field_type'] == $type){
                    echo " selected";
                }
                echo ">" . $type ."</option>";
            }
            ?>
        </select><br><br>
        <input type="checkbox" name="ghazale_ds_field_required_edit" value="Required" <?php if($field['field_required'] == 'Required'){echo 'checked';} ?>/> Required Field <i> ( required fields will be marked by * in the form )</i><br><br>
        <div class="field_ext">
            <i>You can have up to 10 values for this field :</i><br>
            <?php
            $options = explode(" | ", $field['field_ext']);
            for($i=0;$i<=9;$i++){
                echo "<input type=\"text\" name=\"field_ext_edit_".$i."\" value=\"". $options[$i] ."\" /><br>";
            }
            ?>
        </div>
        <input type="submit" name="ghazale_ds_edit_field" value="Update Field">
        <a href="<?php echo get_admin_url()?>admin.php?page=ds-forms" style="text-decoration: none"><input type="button" value="Back to Forms"></a>
    </form>
<?php
}
function ghazale_ds_edit_field_admin_menu(){
    $page_suffix = add_submenu_page(null,'Edit Field','Edit Field','manage_options','ds-edit-field','ghazale_ds_edit_field_admin_page');
    add_action('admin_print_scripts-' . $page_suffix, 'ghazale_ds_admin_field_ext');
}
add_action('admin_menu','ghazale_ds_edit_field_admin_menu');

/**
 * updating field name and type in db
 */

function ghazale_ds_update_field(){
    if(isset($_POST['ghazale_ds_edit_field'])){
        $output ="";
        for ($i = 0; $i <= 9; $i++) {
            if (alphanumericAndSpace($_POST["field_ext_edit_{$i}"]) && trim($_POST["field_ext_edit_{$i}"] !="")){
                $output .= trim($_POST["field_ext_edit_{$i}"]) . " | ";
            }
        }
        if(alphanumericAndSpace($_POST['ghazale_ds_edit_field_name']) && !empty($_POST['ghazale_ds_edit_field_type'])){
            global $wpdb;
            $id = $_GET['ds-edit-field-id'];
            $table = $_GET['ds-edit-field-table'];
            $wpdb->update($table, array('field_name' => $_POST['ghazale_ds_edit_field_name'], 'field_type' => $_POST['ghazale_ds_edit_field_type'], 'field_ext'=> $output, 'field_required'=> $_POST['ghazale_ds_field_required_edit']),array('id'=>$id), array('%s'));
            $_SESSION['ds-message'] = "Updated Successfully";

        }else{
            $_SESSION['ds-message'] = "Please make sure the entered Field Name is not containing symbols, and also make sure you have selected Field Type";
        }
    }
}
add_action('init','ghazale_ds_update_field');

/**
 * deletes selected rows of the form
 */

function ghazale_ds_delete_field(){

    If (isset($_GET['ds-del-field-id']) && isset($_GET['ds-del-field-table'])){
        global $wpdb;
        $wpdb-> delete($_GET['ds-del-field-table'],array('id'=>$_GET['ds-del-field-id']));
    }
}

add_action('init','ghazale_ds_delete_field');

/**
 * showing forms on front end via shortcode with attributes
 */

function ghazale_ds_frontend_forms_shortcode($atts){
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazale_ds_";
    $sql = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
    $tables = $wpdb->get_results($sql,ARRAY_A);
    if(!empty($tables)) {
        foreach ($tables as $table) {
            foreach ($table as $fields_table) {
                shortcode_atts(array('form' => str_replace(array($table_name, '_fields'), '', $fields_table)), $atts);
                if ((str_replace(array($table_name, '_fields'), '', $fields_table)) == $atts['form']) {
                    $sql_fields = "SELECT * FROM " . $fields_table;
                    $fields = $wpdb->get_results($sql_fields, ARRAY_A);
                    $output =  "<p style='background-color: #06B9FD; color: #fff; line-height: 2em;border-left: 5px solid #00008b'>" . ghazale_ds_update(). "</p>";
                    $output .= "<form action=\"\" method=\"post\" id=\"{$fields_table}\" enctype=\"multipart/form-data\">";
                    foreach ($fields as $field) {
                        if($field['field_required'] == "Required"){
                            $output .= $field['field_name'] . "<span style = \"color: red\">*</span>" . ":";
                            $required = strtolower($field['field_required']);
                        }else {
                            $output .= $field['field_name'] . ":";
                            $required = "";
                        }
                        switch ($field['field_type']){
                            case "Text Field":
                                $output.= "<br><input type =\"text\" name= \"".$field['id']."\" size=\"30\" maxlength=\"3000\" value=\"". $_POST[$field['id']] ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Email":
                                $output .= "<br><input type=\"email\" name=\"".$field['id']."\" size=\"30\" maxlength=\"200\" value=\"". $_POST[$field['id']] ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Text Area":
                                $output .= "<br><textarea rows=\"4\" cols=\"40\" name=\"".$field['id']."\" maxlength=\"3000\" ". $required ." >". $_POST[$field['id']] ."</textarea>" . "<br><br>";
                                break;
                            case "Number":
                                $output .= "<br><input type=\"number\" name=\"".$field['id']."\" size=\"30\" maxlength=\"3000\" value=\"". $_POST[$field['id']] ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Telephone":
                                $output .= "<br><input type=\"tel\" name=\"".$field['id']."\" size=\"30\" maxlength=\"50\" value=\"". $_POST[$field['id']] ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "URL":
                                $output .= "<br><input type=\"url\" name=\"".$field['id']."\" size=\"30\" maxlength=\"100\" value=\"". $_POST[$field['id']] ."\" placeholder=\"Should Start with http\" ". $required ." />" . "<br><br>";
                                break;
                            case "Date":
                                $output .= "<br><input type=\"date\" name=\"".$field['id']."\" size=\"30\" value=\"". $_POST[$field['id']] ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "CheckBox":
                                $output .= " <input type=\"checkbox\" name=\"".$field['id']."\" value=\"Yes\" ". $required;
                                if($_POST[$field['id']] == "Yes"){
                                    $output .= " checked";
                                }
                                 $output .= "/>" . "<br><br>";
                                break;
                            case "File Upload":
                                $output .= "<br><input type=\"file\" name=\"ds_file_".$field['id']."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Instruction Text":
                                $output .= "<br><br>";
                                break;
                            case "Drop Down":
                                $output .= "<br><select name=\"".$field['id']."\" ". $required ." >";
                                $output .= "<option value=\"\" >-- Select --</option>";
                                $field_options = explode (" | ", $field['field_ext']);
                                foreach($field_options as $field_option){
                                    if($field_option !="") {
                                        $output .= "<option value='" . $field_option . "'";
                                        if($_POST[$field['id']] == $field_option){
                                            $output .= " selected";
                                        }
                                        $output .= ">" . $field_option . "</option>";
                                    }
                                }
                                $output .= "</select>". "<br><br>";
                                break;
                            case "Multiple Choice":
                                $output .= "<br><select name=\"ds_multiplechoice_".$field['id']."[]\" multiple ". $required ." >";
                                $field_options = explode (" | ", $field['field_ext']);
                                foreach($field_options as $field_option){
                                    if($field_option !="") {
                                        $output .= "<option value='" . $field_option . "'>" . $field_option . "</option>";
                                    }
                                }
                                $output .= "</select>". "<br>";
                                $output .= "<i>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</i><br><br>";
                                break;
                            default:
                                break;
                        }
                    }
                    if(get_option('ghazale_ds_add_captcha')){
                        $a = rand(0,9);
                        $b = rand(0,9);
                        $c = $a + $b;
                        $_SESSION['ds-captcha'] = $c;
                        if(get_option('ghazale_ds_custom_captcha_msg')){
                            $output .= get_option('ghazale_ds_custom_captcha_msg') . "<br>";
                        }else {
                            $output .= "Prove you are not a robot!" . "<br>" . " Write the result of following equation:" . "<br>";
                        }
                        $output .= $a." + ".$b." = <input type=\"text\" name=\"ds-captcha\" size =\"10\"/>" . "<br><br>";
                    }
                    $output .= "<input type=\"submit\" name=\"submit_" . $fields_table . "\" value=\"";
                    if(get_option('ghazale_ds_submit_button_word')){
                        $output .= get_option('ghazale_ds_submit_button_word');
                    }else{
                        $output .= "Submit";
                    }
                    $output .="\" >";

                    $output .= "</form>";
                    return $output;


                }
            }
        }
    }
}
add_shortcode('data-storage','ghazale_ds_frontend_forms_shortcode');

/**
 * adding field inputs to input tables
 */
function ghazale_ds_insert_field_inputs(){
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazale_ds_";
    $tables= $wpdb->get_results("SHOW TABLES LIKE "."'" .$table_name."%_fields'",ARRAY_A);
    $empty_required = array();
    $not_alphanumeric = array();
    if(!empty($tables)) {

        foreach ($tables as $table) {
            foreach ($table as $fields_table) {
                if (isset($_POST['submit_' . $fields_table])) {
                    if (trim($_POST['ds-captcha']) == ghazale_ds_captcha()) {

                        $sql_fields = "SELECT id,field_name,field_required,field_type FROM " . $fields_table;
                        $fields = $wpdb->get_results($sql_fields, ARRAY_A);
                        $input_table = str_replace('_fields', '_inputs', $fields_table);

                        foreach($fields as $field){
                            if($field['field_required'] == "Required" && trim($_POST[$field['id']]) == "" && $field['field_type'] != "Multiple Choice" && $field['field_type'] != "File Upload"){
                                array_push($empty_required,"required");
                            }elseif($field['field_required'] == "Required" && $field['field_type'] == "Multiple Choice") {

                                if(empty($_POST['ds_multiplechoice_'.$field['id']])){
                                    array_push($empty_required,"required");
                                }

                            }elseif(!alphanumericAndSpace($_POST[$field['id']])){
                                array_push($not_alphanumeric,"not alphanumeric");
                            }
                        }
                        if (empty($empty_required) && empty($not_alphanumeric)) {
                            $new_entry = array();
                            foreach ($fields as $field) {
                                if(!empty($_POST['ds_multiplechoice_'.$field['id']])){
                                    $multiple_choice=array();
                                    foreach($_POST["ds_multiplechoice_".$field['id']] as $multiple){
                                        array_push($multiple_choice,$multiple);
                                    }
                                    $_POST[$field['id']] = implode(" | ", $multiple_choice);
                                }
                                    if ($_FILES["ds_file_{$field['id']}"]['size']>0) {
                                        if (!function_exists('wp_handle_upload')) {
                                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                                        }
                                        $uploadedfile = $_FILES["ds_file_{$field['id']}"];
                                        $upload_overrides = array('test_form' => false);
                                        function ghazale_ds_change_upload_dir($upload) {
                                            global $wpdb;
                                            $table_name = $wpdb->prefix . "ghazale_ds_";
                                            $tables= $wpdb->get_results("SHOW TABLES LIKE "."'" .$table_name."%_fields'",ARRAY_A);
                                            foreach ($tables as $table) {
                                                foreach ($table as $fields_table) {
                                                    if (isset($_POST['submit_' . $fields_table])) {
                                                        $new_dir = '/data-storage-' . str_replace(array($table_name,'_fields'),'',$fields_table);
                                                    }
                                                }
                                            }

                                            $upload['path'] = str_replace($upload['subdir'], '', $upload['path']);
                                            $upload['url'] = str_replace($upload['subdir'], '', $upload['url']);
                                            $upload['subdir']  = $new_dir;
                                            $upload['path']   .= $new_dir;
                                            $upload['url']    .= $new_dir;

                                            return $upload;
                                        }
                                        add_filter('upload_dir', 'ghazale_ds_change_upload_dir');
                                        $upload = wp_upload_dir();
                                        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
                                        remove_filter('upload_dir', 'ghazale_ds_change_upload_dir');


                                        if ($movefile && !isset($movefile['error'])) {
                            //                echo "File is valid, and was successfully uploaded.\n";
                            //                var_dump($movefile);
                                            $_POST[$field['id']] = $movefile['url'];
                                        } else {
                                            /**
                                             * Error generated by _wp_handle_upload()
                                             * @see _wp_handle_upload() in wp-admin/includes/file.php
                                             */
                                            $_SESSION['ds-message'] = $movefile['error'];
                                        }
                                    }
                                $wpdb->insert($input_table, array('field_id' => $field['id'], 'field_input' => $_POST[$field['id']]), array('%s'));
                                $_SESSION["ds-update"] = "Entry Submitted!";

                                if($field['field_type'] != "Multiple Choice" && $field['field_type'] != "File Upload"){
                                    if($field['field_type'] == "Email"){
                                        $user_email = $_POST[$field['id']];
                                    }
                                    $new_entry[$field['field_name']] = $_POST[$field['id']];
                                }elseif($field['field_type'] == "Multiple Choice"){
                                    $new_entry[$field['field_name']] = implode(" | ", $multiple_choice);
                                }elseif($field['field_type'] == "File Upload"){
                                    $new_entry[$field['field_name']] = $movefile['url'];
                                }

                            }

                            if(get_option('ghazale_ds_confirmation_email')){
                                $to = $user_email;
                                $subject = "Your recent submission on ".get_bloginfo('name');
                                $message = "<p>".get_option('ghazale_ds_confirmation_msg')."</p>";

                                $header = 'From:' . get_bloginfo('name') .' <';
                                if(get_option('ghazale_ds_confirmation_from')){
                                    $header .= get_option('ghazale_ds_confirmation_from').'>' . "\r\n";;
                                }else{
                                    $header .= get_option('admin_email').'>' . "\r\n";;
                                }
                                wp_mail($to,$subject,$message,$header);

                            }
                            if(get_option('ghazale_ds_update_admin')){
                                $to_admin = get_option('ghazale_ds_update_admin_email');
                                $subject_admin = "You have new entry on your website " .get_bloginfo('name');
                                $message_admin = "<p>You have new entry on your website. Here are the details of this entry:</p>";
                                foreach($new_entry as $key => $entry){
                                    $message_admin .= $key . " : " . $entry . "<br>";
                                }
                                wp_mail($to_admin,$subject_admin,$message_admin);

                            }

                            if(get_option('ghazale_ds_page_redirection')){
                                wp_redirect(get_option('ghazale_ds_page_redirection'));
                                exit;
                            }

                        }elseif(!empty($empty_required)){
                            $_SESSION["ds-update"] = "All required fields should be filled. Required fields are marked with (*)";
                        } elseif(!empty($not_alphanumeric)) {
                            $_SESSION["ds-update"] = "Symbols are not allowed for security. Please reconsider your entries.";
                        }
                    }else{
                        $_SESSION["ds-update"] = "The entered captcha is incorrect. Please enter the correct value.";
                    }
                }
            }
        }
    }
}
add_action('wp_loaded','ghazale_ds_insert_field_inputs');


/**
 * shows form inputs on the backend
 */

function ghazale_ds_form_inputs(){
    global $wpdb;
    $tables = $wpdb-> prefix. "ghazale_ds_";
    $input_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_inputs'",ARRAY_A);
    $field_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_fields'",ARRAY_A);

    if(!empty($input_tables)) {
        echo ghazale_ds_message();
        echo "<div id=\"form_tabs\">";
        echo "<ul>";
        foreach ($input_tables as $input_table) {
            foreach ($input_table as $table) {
                echo "<li><a href=\"#". $table. "\">" . ucfirst(str_replace(array($tables, "_inputs"), "", $table)) . " Inputs</a></li>";
            }
        }
        echo "</ul>";
        foreach ($input_tables as $input_table) {
            foreach ($input_table as $table) {
                echo "<div id=\"".$table ."\">";

                echo "<h3>" . ucfirst(str_replace(array($tables, "_inputs"), "", $table)) . " Inputs</h3>";
                echo "<p><input type=\"button\" name=\"ds_download_table_csv\" class=\"ds_download_table_csv\" value=\"Download Table In CSV Format\" /><i> After you downloaded the table, rename the file and put <strong>\".csv\"</strong> at the end of the file name.</i></p>";
                echo "<table class = \"table download_".$table."\">";
                $inputs_sql = "SELECT * FROM " . $table;
                $inputs = $wpdb->get_results($inputs_sql, ARRAY_A);

                foreach($field_tables as $field_table){
                    foreach($field_table as $field_table_single){
                        if($field_table_single == str_replace("_inputs","_fields","$table")){
                            $fields_sql = "SELECT id,field_name FROM ". $field_table_single;
                            $fields = $wpdb->get_results($fields_sql,ARRAY_A);
                            if(!empty($inputs)){
                                echo "<tr>";
                                foreach($fields as $field){
                                    echo "<th>". $field['field_name'] . "</th>";
                                }
                                echo "</tr>";
                                foreach($fields as $field){
                                    $first_id = $field['id'];
                                    break;
                                }

                                foreach($fields as $field){
                                    $last_id = $field['id'];
                                }

                                foreach($inputs as $input){
                                    if($input['field_id'] == $first_id) {
                                        echo "<tr>";
                                    }
                                    foreach ($input as $key=>$input_single) {
                                          if ($input_single != "" && $key != 'id' && $key != 'field_id') {
                                              if(substr( $input_single, 0, 4 ) === "http"){
                                                  echo "<td><a href='" . $input_single . "' target='_blank'>".$input_single."</a></td>";
                                              }else {
                                                  echo "<td>" . $input_single . "</td>";
                                              }
                                          }elseif ($input_single == "") {
                                              echo "<td> </td>";
                                          }
                                    }
                                    if($input['field_id'] == $last_id) {
                                        echo "</tr>";
                                    }
                                }

                            }else{
                                    echo "There is no input";
                            }
                        }
                    }
                }
                echo "</table>";
                echo "<p><a href=\"" . get_admin_url() . "admin.php?page=ds-form-entries&ds-del-data-input-table=" . $table . "\" style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"Delete All Data in This Input Table\"></a></p>";
                echo "<p><a href=\"" . get_admin_url() . "admin.php?page=ds-form-entries&ds-total-del-input-table-and-corresponding-form-table=" . $table . "\" style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"Totally Delete This Input Table AND Its Corresponding Form\"></a></p>";
                echo "</div>";
            }

        }
        echo "</div>";
    }else{
        echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"> <strong>No inputs to display. Once you had inputs from your form, they will appear on this page in an organized table.</strong></div>";
    }
}
function ghazale_ds_form_inputs_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage','Inputs','Inputs','manage_options','ds-form-entries','ghazale_ds_form_inputs');
    add_action('admin_print_scripts-' . $page_suffix, 'ghazale_ds_admin_input_table_tabs');
}
add_action('admin_menu','ghazale_ds_form_inputs_admin_menu');

function ghazale_ds_admin_input_table_tabs(){
    wp_enqueue_style('ds-tabs-style');
    wp_enqueue_style('ds-table-style');
    wp_enqueue_script('ds-tabs-script');
    wp_enqueue_script('ds-jquery-base64');
    wp_enqueue_script('ds-table-export');
}

//function ghazale_ds_admin_input_table_tabs_register(){
//    wp_register_style('ds-tabs-style',plugins_url('css/jquery-ui.min.css',__FILE__));
//    wp_register_style('ds-table-style', plugins_url('css/ds-table-style.css',__FILE__));
//    wp_register_script('ds-tabs-script', plugins_url('js/ds-admin-tabs.js',__FILE__),array('jquery','jquery-ui-core','jquery-ui-tabs'));
//}
//add_action('admin_init','ghazale_ds_admin_input_table_tabs_register');

function ghazale_ds_admin_input_table_download_button_register(){
    wp_register_script('ds-jquery-base64', plugins_url('js/jquery.base64.js',__FILE__),array('jquery'));
    wp_register_script('ds-table-export',plugins_url('js/tableExport.js',__FILE__),array('jquery'));
}
add_action('admin_init','ghazale_ds_admin_input_table_download_button_register');

/**
 * delete selected input table
 */
function ghazale_ds_totally_delete_input_table(){
    if(isset($_GET['ds-del-data-input-table']) && $_GET['page'] == 'ds-form-entries'){
        global $wpdb;
        $tables = $wpdb-> prefix. "ghazale_ds_";
        $input_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_inputs'",ARRAY_A);
        foreach($input_tables as $input_table){
            foreach($input_table as $table){
                if($table == $_GET['ds-del-data-input-table']){
                    $del_sql= "SELECT id FROM ". $table;
                    $rows= $wpdb->get_results($del_sql,ARRAY_A);
                    foreach($rows as $row){
                        $wpdb->delete($table,array('id' => $row['id']));
                    }
                    $_SESSION['ds-message'] = "Deleted Successfully";
                }
            }
        }
    }
}

add_action('init','ghazale_ds_totally_delete_input_table');

/**
 * delete input table and its corresponding form table
 */
function ghazale_ds_totally_delete_input_table_and_corresponding_form_table(){
    if(isset($_GET['ds-total-del-input-table-and-corresponding-form-table'])){
        global $wpdb;
        $tables = $wpdb-> prefix. "ghazale_ds_";
        $input_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_inputs'",ARRAY_A);
        foreach($input_tables as $input_table){
            foreach($input_table as $table){
                if($table == $_GET['ds-total-del-input-table-and-corresponding-form-table']){
                    $wpdb->query("DROP TABLE IF EXISTS ". $table);
                    $_SESSION['ds-message'] = "Deleted Successfully";
                }
            }
        }
        $field_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_fields'",ARRAY_A);
        $form = str_replace("_inputs","_fields",$_GET['ds-total-del-input-table-and-corresponding-form-table']);
        foreach($field_tables as $field_table){
            foreach($field_table as $form_table){
                if($form_table == $form){
                    $wpdb->query("DROP TABLE IF EXISTS ". $form);
                    $_SESSION['ds-message'] = "Deleted Successfully";
                }
            }
        }
    }
}
add_action('init','ghazale_ds_totally_delete_input_table_and_corresponding_form_table');

/**
 * general settings
 */

function ghazale_ds_general_settings(){
    ?>
    <form action="options.php" id="ghazale_ds_general_dettings" method="post">
        <?php settings_errors(); ?>
        <?php settings_fields('ghazale_ds_settings'); ?>
        <div id="settings_accordion">
        <h3>Captcha and Submit Button Value</h3>
            <div>
        <h4>Captcha</h4>
        <input type="checkbox" name="ghazale_ds_add_captcha" id="ghazale_ds_add_captcha" value="1" <?php
        checked(get_option('ghazale_ds_add_captcha'), 1);
        ?>/> I want to add captcha to my forms. <i> (for fighting against spams and spam bot)</i> <br><br>
        Add Custom Captcha Message: <br>
        <textarea rows="4" cols="40" name="ghazale_ds_custom_captcha_msg"><?php
        if(get_option('ghazale_ds_custom_captcha_msg')){
            echo get_option('ghazale_ds_custom_captcha_msg');
        } else{
            echo "Prove you are not a robot!";
        }
        ?></textarea><br><br>
        <h4>Submit Button Value</h4>
        Change the word on "Submit" button to whatever you want.<br>
        Submit Button Word: <input type="text" name="ghazale_ds_submit_button_word" value="<?php
        if(get_option('ghazale_ds_submit_button_word')){
            echo get_option('ghazale_ds_submit_button_word');
        } else{
            echo "Submit";
        }
        ?>"/><br><br>
            </div>
        <h3>Page Redirection</h3>
            <div>
        Custom Thank You/Confirmation Page Redirection.<br>
        Redirection Page URL: <input type="url" placeholder="Should start with http" size="30" name="ghazale_ds_page_redirection" value="<?php echo get_option('ghazale_ds_page_redirection'); ?>" /><i> If you don't wish to redirect user, leave it blank.</i><br><br>
            </div>
        <h3>Confirmation Email</h3>
            <div>
        <input type="checkbox" name="ghazale_ds_confirmation_email" value="1" <?php
        checked(get_option('ghazale_ds_confirmation_email'), 1);
        ?>/> Send confirmation Email to user.<br><br>
        From: <input type="email" name="ghazale_ds_confirmation_from" value="<?php
        if(get_option('ghazale_ds_confirmation_from')) {
            echo get_option('ghazale_ds_confirmation_from');
        }else{
            echo get_option('admin_email');
        }
        ?>"/><i> This is the email that user will see when they receive confirmation/thank you email</i><br><br>
        Message: <i> (Confirmation/ Thank you Email Message)</i><br>
        <textarea name="ghazale_ds_confirmation_msg" rows="5" cols="40" ><?php echo get_option('ghazale_ds_confirmation_msg'); ?></textarea><br><br>
            </div>
        <h3>Update Admin</h3>
            <div>
        <input type="checkbox" name="ghazale_ds_update_admin" value="1" <?php
        checked(get_option('ghazale_ds_update_admin'), 1);
        ?> /> Update admin when new entry is submitted <br><br>
        Admin Email : <input type="email" name="ghazale_ds_update_admin_email" value="<?php
        if(get_option('ghazale_ds_update_admin_email')) {
            echo get_option('ghazale_ds_update_admin_email');
        }else{
            echo get_option('admin_email');
        }
        ?>" /><br><br>
            </div>
        </div>
        <br>
        <input type="submit" name="ghazale-ds-submit-general_settings" value="Save Settings">
    </form>
<?php
}
function ghazale_ds_general_settings_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage','General Settings','General Settings','manage_options','ds-general-settings','ghazale_ds_general_settings');
    add_action('admin_print_scripts-'. $page_suffix,'ghazale_ds_accordion_settings');
}
add_action('admin_menu','ghazale_ds_general_settings_admin_menu');

function ghazale_ds_accordion_settings(){
    wp_enqueue_script('ghazale-ds-settings-accordion');
    wp_enqueue_style('ghazale-ds-accordion-style');
}
function ghazale_ds_register_accordion_settings(){
    wp_register_script('ghazale-ds-settings-accordion',plugins_url('js/ds-admin-accordion.js',__FILE__),array('jquery','jquery-ui-core','jquery-ui-accordion'));
    wp_register_style('ghazale-ds-accordion-style',plugins_url('css/jquery-ui-accordion.min.css',__FILE__));
}
add_action('admin_init','ghazale_ds_register_accordion_settings');