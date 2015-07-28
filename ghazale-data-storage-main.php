<?php
/*
Plugin Name: Data Storage
Plugin URI: http://ghazale.co.nf/index.php/2015/05/30/data-storage-version-2-1-1
Description: Fully customizable,editable,downloadable data table creator. You can have multiple different forms and their corresponding tables in one wordpress system. Equipped with instant feedback to user upon submitting the form. Perfect for collecting people's data, information, inquiries and many other purposes such as online contests. In addition of having the data in the backend, you also have the option to receive the details of the submitted data, right in your email as well. There's also the option to send Thank you/Confirmation email to the user with customized text and address as well as many other cool features.
Author: Ghazale Shirazi
Version: 2.2.5
Text Domain: data-storage
Domain Path: /languages
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
    <h2><?php _e('Welcome to Data Storage (v2.2.5)', 'data-storage'); ?></h2>
    <?php
    if($results) {
        ?>
        <h3><?php _e('Your Old Table','data-storage'); ?></h3>
        <div style="border: 1px solid #404040; padding: 10px"><?php _e('If you previously had the old version of Data Storage, your old data is still safe. You can view or download it here.', 'data-storage'); ?>
        <br><i><?php _e('It is recommended to use the new version of Data Storage as it has more security, more flexibility, more stability, and ability to have multiple forms (and tables)','data-storage'); ?>.</i></br></div>
        <p><input type="button" class="ds_show_hide_old_table" value="<?php _e('Show My Old Table','data-storage'); ?>" style="background-color: #404040; border: #404040; color: #ffffff; cursor: pointer" /></p>
        <hr>
        <div class="div_show_hide_old_table">
        <p><input type="button" name="ds_download_old_table_csv" class="ds_download_old_table_csv" value="<?php _e('Download Table In CSV Format','data-storage'); ?>" /><i> <?php _e('After you downloaded the table, rename the file and put ".csv" at the end of the file name to be able to open it in excel','data-storage'); ?>.</i></p>
            <p><a href="<?php echo get_admin_url(); ?>admin.php?page=ds-data-storage&ds-old-data-table=ds-totally-delete-old-data-table" style="text-decoration: none" onclick="return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)')"><input type="button" value="<?php _e('Totally Delete This Old Table. I Don\'t Need It','data-storage'); ?>" /></a><i> <?php _e('You can totally delete this table if you don\'t want it anymore', 'data-storage'); ?>'</i></p>
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
    <p><strong><?php _e('The shortcode in the new version of Data Storage has dynamic attribute which lets you to have multiple (and unlimited!) different forms at the same time','data-storage'); ?>.</strong></p>
    <div style="color:#404040 ;background-color:#b6c669 ; padding: 10px"><strong><?php _e('As soon as you create a new form and add form fields to your newly created form, you will see the automatically generated shortcode for the corresponding form in the "Forms" section under "Data Storage" menu. So you don\'t have to memorize any shortcode. It\'s always there for your reference for all of your forms','data-storage'); ?>.</strong></div>
    <hr>
    <div style="color:#404040 ;background-color:#aaffaa ; padding: 10px"><strong><?php _e('If you liked this plugin and find it helpful, please rate it 5 stars!','data-storage'); ?><a href="https://wordpress.org/support/view/plugin-reviews/data-storage?rate=5#postform"><img src="<?php echo plugins_url('images/5stars.png',__FILE__); ?>"></a> <br><?php _e('Your donation will be used to protect helpless animals. It is highly appreciated!','data-storage'); ?> <i><?php _e('(Please write "plugin" in the comment area on donation page)','data-storage'); ?></i></p></strong><p><a href="http://www.vafashelter.com/main/en/helping-us/paypal-donation" target="_blank"><img src="<?php echo plugins_url('images/btn_donatecc_lg.gif',__FILE__); ?>" alt="btn donatecc lg"></a></p></div>
    <hr>
    <h3><?php _e('Making Your First Form','data-storage'); ?></h3>
    <p><?php _e('To make a new form, follow these steps','data-storage'); ?>:</p>
    <ol>
        <li><?php _e('Click on "Create New Form" menu. Name your new form and create it.','data-storage'); ?></li>
        <li><?php _e('Click on "Add Fields" menu. Select your newly created form, name your field and choose field type (e.g.: Text Input, Checkbox, DropDown, etc). You can also choose whether you want this field to be "Required" or not.','data-storage'); ?></li>
        <li><?php _e('Repeat number 2 and add as much as fields you like! (You can add unlimited number of fields to your form)','data-storage'); ?></li>
        <li><?php _e('Your form is ready to use! Click on "Form" menu. You can see the automatically generated shortcode for this form to use on any post or page. You can also edit or delete any of the form fields here.','data-storage'); ?></li>
        <li><?php _e('Enjoy!','data-storage'); ?></li>

    </ol>
    <h3><?php _e('Having Your First Inputs','data-storage'); ?></h3>
    <p><?php _e('Once you put the shorcode of your created form on your desired page, you can see the awesome form that you\'ve just made. When this form is filled with data and gets submitted, you can see the inserted data in the backend of your site in "Inputs" section under "Data Storage" menu.','data-storage'); ?></p>
    <hr>
    <h3><?php _e('General Settings','data-storage'); ?></h3>
    <p><?php _e('In the "General Settings" tab, I\'ve put some useful options:','data-storage'); ?></p>
    <ol>
        <li><?php _e('You can have Captcha on your forms to fight against spams and robots.','data-storage'); ?></li>
        <li><?php _e('You can change the word on "Submit" button.','data-storage'); ?></li>
        <li><?php _e('You can choose to inform admin when there is a new form submission.','data-storage'); ?></li>
        <li><?php _e('You can choose to send confirmation email to user with custom message.','data-storage'); ?></li>
        <li><?php _e('You can have a custom page redirection upon form submission','data-storage'); ?></li>
        <i><?php _e('Even if you don\'t wish to redirect user to another page, the plugin will handle the feedback for the user. So they realize that their entry has been successfully submitted.','data-storage'); ?></i>
    </ol>
    <hr>
    <div style="color:#707070; background-color: #cccccc ; border: 1px solid #cccccc; padding: 10px"><?php _e('If you ever had questions, suggestions or comments feel free to express yourself on support forum','data-storage'); ?> <a href="mailto:ghsh88@gmail.com"><?php _e('or drop me a line','data-storage'); ?></a> :)</div>
    <?php
}
function ghazale_ds_welcome_page_admin_menu(){
    $page_suffix = add_menu_page('Data Storage','Data Storage','manage_options','ds-data-storage','ghazale_ds_welcome_page', plugin_dir_url(__FILE__) . 'images/ic_data_storage.png');
    add_submenu_page('ds-data-storage',__('Welcome','data-storage'),__('Welcome','data-storage'),'manage_options','ds-data-storage','ghazale_ds_welcome_page');
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
        <h2><?php _e('Create New Form','data-storage'); ?></h2>
        <?php _e('Form Name','data-storage'); ?>: <input type="text" name="ghazale_ds_new_form_name" id="ghazale_ds_new_form_name" value="<?php if(isset($_POST['ghazale_ds_new_form_name'])){ echo $_POST['ghazale_ds_new_form_name']; }else{ echo '';} ?>"/><i> <?php _e('Please enter letters and numbers only. No spaces.','data-storage'); ?></i>
        <br><br><input type="submit" name="ghazale_ds_submit_new_form" value="<?php _e('Create Form','data-storage'); ?>">
    </form>
<?php
}
function ghazale_ds_new_form_admin_menu(){
    add_submenu_page('ds-data-storage',__('Create New Form','data-storage'),__('Create New Form','data-storage'),'manage_options','ds-create-new-form','ghazale_ds_new_form');
}
add_action('admin_menu','ghazale_ds_new_form_admin_menu');

/**
 * creates 2 relational tables upon admin request
 */
function ghazale_ds_create_tables(){
    if(isset($_POST['ghazale_ds_submit_new_form'])) {
        if (ctype_alnum(trim($_POST['ghazale_ds_new_form_name']))) {
            global $wpdb;
            $table_name = $wpdb->prefix . "ghazale_ds_" . strtolower(trim($_POST['ghazale_ds_new_form_name']));
            $tables= $wpdb->get_results("SHOW TABLES LIKE "."'" .$table_name."%'");
            if (count($tables)== 0) {
                $sql_form = "CREATE TABLE " . $table_name . "_fields (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_required VARCHAR (8) COLLATE ascii_bin, PRIMARY KEY (id))";
                $wpdb->query($sql_form);
                $sql_input = "CREATE TABLE " . $table_name . "_inputs (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_id INTEGER(10), field_input VARCHAR(3000) COLLATE utf8_bin, PRIMARY KEY (id))";
                $wpdb->query($sql_input);
                $_SESSION['ds-message'] = esc_html__('Form Created Successfully','data-storage');
            } else {
                $_SESSION['ds-message'] = esc_html__('That name already exists','data-storage');
            }

        } else {
            $_SESSION['ds-message'] = esc_html__('The form name SHOULD be alphanumeric. Please enter a valid name','data-storage');
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
        <h2><?php _e('Add Fields To The Form', 'data-storage'); ?></h2>
        <p><strong><?php _e('Add fields to your forms as much as you like!','data-storage'); ?></strong></p>
        <p><i><?php _e('Note: You cannot add fields to the forms that has already received inputs. The forms that have inputs are locked against changes. If you wish to edit or add fields to those forms, you should first delete their correspondent input data.', 'data-storage'); ?></i></p>
        <?php _e('Select Form','data-storage'); ?>: <select name="ghazale_ds_select_form">
            <option value=""> -- <?php _e('Select Form','data-storage'); ?> -- </option>
            <?php
            foreach($tables as $table){
                foreach ($table as $select_table) {
                    $input_table_query = 'SELECT * FROM '. str_replace('_fields', '_inputs', $select_table);
                    $input_table_query_result = $wpdb->get_results($input_table_query,ARRAY_A);
                    if (empty($input_table_query_result)) {
                        echo "<option value='" . $select_table . "'";
                        if (isset($_POST['ghazale_ds_select_form']) && $_POST['ghazale_ds_select_form'] == $select_table) {
                            echo " selected";
                        }
                        echo ">" . ucfirst(str_replace(array($table_name, '_fields'), '', $select_table)) . "</option>";
                    }
                }
            }
            ?>
        </select><i> <?php _e('Select the form to which you want to add the field','data-storage'); ?></i><br><br>
        <?php _e('Field Name','data-storage'); ?>: <input type="text" name="ghazale_ds_field_name" id="ghazale_ds_field_name" maxlength="300" placeholder="Enter Field Name" value="<?php if(isset($_POST['ghazale_ds_field_name'])){ echo trim($_POST['ghazale_ds_field_name']); }else{ echo ''; } ?>"/><i> <?php _e('Example: Name, Email, Address, etc... (Should be Alphanumeric. Can have space and allowed Symbols: @-_.,\/:())','data-storage'); ?></i><br><br>
        <?php $type_array = array("Text Field","Text Area","Drop Down","Multiple Choice","Email","File Upload","Number","Telephone","URL","Date","CheckBox","Instruction Text"); ?>
        <?php _e('Field Type','data-storage'); ?>: <select name="ghazale_ds_field_type" class="ghazale_ds_field_type">
            <option value=""> -- <?php _e('Select Field Type','data-storage'); ?> -- </option>
            <?php
            foreach($type_array as $type){
                echo "<option value='" . $type . "'" ;
                if(isset($_POST['ghazale_ds_field_type']) && $_POST['ghazale_ds_field_type'] == $type){
                    echo " selected";
                }
                echo ">" . $type ."</option>";
            }
            ?>
        </select><i> <?php _e('Select the field type','data-storage'); ?></i><br><br>
        <span  id="ghazale_ds_field_required"><input type="checkbox" name="ghazale_ds_field_required" value="Required" <?php if(isset($_POST['ghazale_ds_field_required'])){echo 'checked';} ?>/> <?php _e('Required Field','data-storage'); ?> <i> (<?php _e('required fields will be marked by * in the form','data-storage'); ?>)</i><br><br></span>
        <p class="user_guide"></p>
        <div class="field_ext">
            <i><?php _e('You can have up to 10 values for this field','data-storage'); ?> :</i><br>
            <?php
            for($i=0;$i<=9;$i++){
                echo "<input type=\"text\" name=\"field_ext_".$i."\" value=\"". (isset($_POST["field_ext_{$i}"])? $_POST["field_ext_{$i}"] :'') ."\" /><br>";
            }
            ?>
        </div>

        <br><input type="submit" name="ghazale-ds-submit-field-name" value="<?php _e('Add Field','data-storage'); ?>">
    </form>
<?php
}

function ghazale_ds_add_fields_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage',__('Add Fields','data-storage'),__('Add Fields','data-storage'),'manage_options','ds-add-field','ghazale_ds_add_fields');
    add_action('admin_print_scripts-' . $page_suffix, 'ghazale_ds_admin_field_ext');
}
add_action('admin_menu','ghazale_ds_add_fields_admin_menu');


function ghazale_ds_admin_init_field_ext(){
    wp_register_script('ds-field-ext',plugins_url('js/ds-data-storage.js',__FILE__),array('jquery'));
// Localize the script with new data
    $translation_array = array(
        'string1' => __( 'This field type is intended to give instructions to the user in certain parts of the form. (Example: Please write your surname in capital letters.)', 'data-storage' ),
        'string2'   => __('The maximum allowed size for file upload can be adjusted in the General Settings but it also depends on your server settings', 'data-storage'),
        'a_value' => '10'
    );
    wp_localize_script( 'ds-field-ext', 'object_name', $translation_array );
}
add_action('admin_init','ghazale_ds_admin_init_field_ext');

function ghazale_ds_admin_field_ext(){
    wp_enqueue_script('ds-field-ext');

}


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
    register_setting('ghazale_ds_settings', 'ghazale_ds_submit_button_word');
    register_setting('ghazale_ds_settings', 'ghazale_ds_max_upload_size');
}
add_action('admin_init','ghazale_ds_register_settings');

/**
 * @param $string
 * @return mixed
 * sanitizing input before they get inserted to db
 */

function alphanumericAndSpace( $string )
{
    return !preg_match('/[^\w\p{L}\p{N}\p{Pd} @-_.,\/:()\n\r]/u', $string);
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
                $wpdb->insert($_POST['ghazale_ds_select_form'], array('field_name' => stripcslashes(trim($_POST['ghazale_ds_field_name'])), 'field_type' => $_POST['ghazale_ds_field_type'], 'field_ext'=> $output , 'field_required'=> (isset($_POST['ghazale_ds_field_required'])? $_POST['ghazale_ds_field_required'] : '')), array('%s'));
                $_SESSION['ds-message'] = esc_html__('Field Added Successfully','data-storage');
            }elseif($_POST['ghazale_ds_field_type'] == "Instruction Text"){
                $wpdb->insert($_POST['ghazale_ds_select_form'], array('field_name' => stripcslashes(trim($_POST['ghazale_ds_field_name'])), 'field_type' => $_POST['ghazale_ds_field_type']), array('%s'));
                $_SESSION['ds-message'] = esc_html__('Field Added Successfully','data-storage');
            }else {
                $wpdb->insert($_POST['ghazale_ds_select_form'], array('field_name' => stripcslashes(trim($_POST['ghazale_ds_field_name'])), 'field_type' => $_POST['ghazale_ds_field_type'],'field_required'=> (isset($_POST['ghazale_ds_field_required'])? $_POST['ghazale_ds_field_required'] : '')), array('%s'));
                $_SESSION['ds-message'] = esc_html__('Field Added Successfully','data-storage');
            }
        }else{
            $_SESSION['ds-message'] = esc_html__('All fields are required. Please make sure you have filled all fields (Also make sure the entered Field Name is not containing disallowed symbols)','data-storage');
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
                $sql_fields = "SELECT * FROM {$fields_table} ORDER BY id ASC";
                $fields_query= $wpdb->get_results($sql_fields, ARRAY_A);
                $sql_inputs = "SELECT * FROM ". str_replace('_fields','_inputs', $fields_table) . " ORDER BY id ASC";
                $inputs_query =$wpdb->get_results($sql_inputs,ARRAY_A);
                echo "<div id=\"". $fields_table ."\">";
                if (!empty($fields_query)) {
                    echo "<h2>". ucfirst(str_replace(array($table_name,'_fields'),'',$fields_table)) ."</h2>";
                    echo "<p><strong>Shortcode : </strong>[data-storage form=\"". str_replace(array($table_name,'_fields'),'',$fields_table) . "\"]</p>";
                    if(!empty($inputs_query)){ echo '<p><i>'.__('This form has already received inputs and cannot be modified. If you wish to modify this form, you should first delete its corresponding input data from "Inputs" menu.','data-storage').'</i></p>';}
                    echo "<table class=\"table\"><tr><th>".__('Delete','data-storage')."</th><th>".__('Edit','data-storage')."</th><th>Reorder</th><th>Field Name</th><th>Field Type</th><th>Extensions</th><th>Required</th></tr>";
                    foreach($fields_query as $fields){
                        echo "<tr>";
                        echo "<td><a href='". get_admin_url() ."admin.php?page=ds-forms&ds-del-field-id=".$fields['id'] ."&ds-del-field-table=". $fields_table."#". $fields_table."' style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"Delete\" ".(!empty($inputs_query)? 'disabled': '')."></a> </td>";
                        echo "<td><a href='". get_admin_url() ."admin.php?page=ds-edit-field&ds-edit-field-id=".$fields['id'] ."&ds-edit-field-table=". $fields_table."#". $fields_table."' style=\"text-decoration: none\" ><input type=\"button\" value=\"Edit\" ".(!empty($inputs_query)? 'disabled': '')."></a> </td>";
                        echo "<td><a href='". get_admin_url() ."admin.php?page=ds-forms&ds-field-reorder-down-id=".$fields['id'] ."&ds-field-reorder-down-table=". $fields_table."#". $fields_table."' style=\"text-decoration: none\" ><input type='button' value='&#x25BC;' ".(!empty($inputs_query)? 'disabled': '')."></a>". "<a href='". get_admin_url() ."admin.php?page=ds-forms&ds-field-reorder-up-id=".$fields['id'] ."&ds-field-reorder-up-table=". $fields_table."#". $fields_table."' style=\"text-decoration: none\" ><input type='button' value='&#x25B2;' ".(!empty($inputs_query)? 'disabled': '')."></a>" ."</td>";
                        echo "<td>" . $fields['field_name'] . "</td>";
                        echo "<td>" . $fields['field_type'] . "</td>";
                        echo "<td>" . $fields['field_ext'] . "</td>";
                        echo "<td>" . $fields['field_required'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table><br>";

                }else{
                    echo "<br>".__('There are no fields for this form yet.','data-storage')." <a href=\"".get_admin_url() ."admin.php?page=ds-add-field\"> ".__('Add fields to this form')."</a><br><br>";
                }
                echo "<a href=\"".get_admin_url() ."admin.php?page=ds-forms&ds-total-del-form-table=". $fields_table ."\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\" ><input type=\"button\" value=\"".__('Totally Delete This Form AND Its Corresponding Inputs Table.','data-storage')."\"></a>";
                echo "</div>";
            }
        }
    }else{
        echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"><strong>". __('No form(s) to display. Please Create a new form first. Once you create your first form and add fields to it, it will appear on this page in an organized table.','data-storage') ."</strong></div>";
    }
    echo "</div>";

}
function ghazale_ds_created_tables_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage',__('Forms','data-storage'),__('Forms','data-storage'),'manage_options','ds-forms','ghazale_ds_created_forms');
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
 * Reorder form fields
 */
function ghazale_ds_reorder_form_fields(){
    if(isset($_GET['ds-field-reorder-down-id']) && isset($_GET['ds-field-reorder-down-table'])){
        global $wpdb;
        $next_available_id = 'SELECT id FROM '. $_GET['ds-field-reorder-down-table'] . ' WHERE id > '.$_GET['ds-field-reorder-down-id']. ' ORDER BY id ASC LIMIT 1';
        $next_id = $wpdb->get_var($next_available_id);

        // create temporary table
        if($wpdb->get_var("SHOW TABLES LIKE 'temp'") == NULL) {
            $wpdb->query('CREATE TEMPORARY TABLE temp (field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_required VARCHAR (8) COLLATE ascii_bin)');
        }
        $current_row = 'SELECT field_name,field_type,field_ext,field_required FROM '. $_GET['ds-field-reorder-down-table'] . ' WHERE id='. $_GET['ds-field-reorder-down-id'];
        $current_row_query = $wpdb->get_results($current_row,ARRAY_A);

        //store original value of current row in temp table
        foreach($current_row_query as $field){
            $wpdb->insert('temp', array('field_name'=>$field['field_name'], 'field_type'=>$field['field_type'],'field_ext'=>$field['field_ext'], 'field_required'=>$field['field_required'] ));
        }
        $temp_result = $wpdb->get_results('SELECT * FROM temp',ARRAY_A);

        //get the values of next row
        $next_row = 'SELECT field_name,field_type,field_ext,field_required FROM '.$_GET['ds-field-reorder-down-table'] . ' WHERE id='. $next_id;
        $next_row_query = $wpdb->get_results($next_row,ARRAY_A);

        //replace the values of rows
        foreach($next_row_query as $replace){
            $wpdb->update($_GET['ds-field-reorder-down-table'], array('field_name'=>$replace['field_name'], 'field_type'=>$replace['field_type'],'field_ext'=>$replace['field_ext'], 'field_required'=>$replace['field_required'] ), array('id'=>$_GET['ds-field-reorder-down-id']));
        }
        foreach($temp_result as $result){
            $wpdb-> update($_GET['ds-field-reorder-down-table'],array('field_name'=>$result['field_name'], 'field_type'=>$result['field_type'],'field_ext'=>$result['field_ext'], 'field_required'=>$result['field_required']) , array('id'=>$next_id));
        }

                        wp_redirect(get_admin_url().'admin.php?page=ds-forms');
    }
    if(isset($_GET['ds-field-reorder-up-id']) && isset($_GET['ds-field-reorder-up-table'])){
        global $wpdb;
        $previous_available_id = 'SELECT id FROM '. $_GET['ds-field-reorder-up-table'] . ' WHERE id < '.$_GET['ds-field-reorder-up-id']. ' ORDER BY id DESC LIMIT 1';
        $previous_id = $wpdb->get_var($previous_available_id);

        //create temporary table
        if($wpdb->get_var("SHOW TABLES LIKE 'temp'") == NULL) {
            $wpdb->query('CREATE TEMPORARY TABLE temp (field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_required VARCHAR (8) COLLATE ascii_bin)');
        }
        $current_row = 'SELECT field_name,field_type,field_ext,field_required FROM '. $_GET['ds-field-reorder-up-table'] . ' WHERE id='. $_GET['ds-field-reorder-up-id'];
        $current_row_query = $wpdb->get_results($current_row,ARRAY_A);

        //store original value of current row in temp table
        foreach($current_row_query as $field){
            $wpdb->insert('temp', array('field_name'=>$field['field_name'], 'field_type'=>$field['field_type'],'field_ext'=>$field['field_ext'], 'field_required'=>$field['field_required'] ));
        }
        $temp_result = $wpdb->get_results('SELECT * FROM temp',ARRAY_A);

        //get the values of previous row
        $previous_row = 'SELECT field_name,field_type,field_ext,field_required FROM '.$_GET['ds-field-reorder-up-table'] . ' WHERE id='. $previous_id;
        $previous_row_query = $wpdb->get_results($previous_row,ARRAY_A);

        //replace the values of rows
        foreach($previous_row_query as $replace){
            $wpdb->update($_GET['ds-field-reorder-up-table'], array('field_name'=>$replace['field_name'], 'field_type'=>$replace['field_type'],'field_ext'=>$replace['field_ext'], 'field_required'=>$replace['field_required'] ), array('id'=>$_GET['ds-field-reorder-up-id']));
        }
        foreach($temp_result as $result){
            $wpdb-> update($_GET['ds-field-reorder-up-table'],array('field_name'=>$result['field_name'], 'field_type'=>$result['field_type'],'field_ext'=>$result['field_ext'], 'field_required'=>$result['field_required']) , array('id'=>$previous_id));
        }
                        wp_redirect(get_admin_url().'admin.php?page=ds-forms');
    }

}
add_action('init','ghazale_ds_reorder_form_fields');
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
                    $_SESSION['ds-message'] = esc_html__('Deleted Successfully','data-storage');
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
                    $_SESSION['ds-message'] = esc_html__('Deleted Successfully','data-storage');
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
    <h2><?php _e('Edit Field','data-storage'); ?></h2>
    <?php echo ghazale_ds_message(); ?>
    <form action="" method="post" id="ghazale_ds_edit_field">
        <h4><?php _e('Form','data-storage'); ?> : <?php echo ucfirst(str_replace(array($db_table_name, "_fields"),"", $_GET['ds-edit-field-table'])); ?> </h4>
        <?php _e('Field Name','data-storage'); ?> : <input type="tex" name="ghazale_ds_edit_field_name" id="ghazale_ds_edit_field_name" value="<?php echo $field['field_name']; ?>"/><i> Should be alphanumeric. Can have space and allowed symbols @-_.,\/:().</i><br><br>
        <?php $type_array = array("Text Field","Text Area","Drop Down","Multiple Choice","Email","File Upload","Number","Telephone","URL","Date","CheckBox","Instruction Text"); ?>
        <?php _e('Field Type','data-storage'); ?>: <select name="ghazale_ds_edit_field_type" class="ghazale_ds_field_type">
            <option value=""> -- <?php _e('Select Field Type','data-storage'); ?> -- </option>
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
        <span  id="ghazale_ds_field_required"><input type="checkbox" name="ghazale_ds_field_required_edit" value="Required" <?php if($field['field_required'] == 'Required'){echo 'checked';} ?>/> <?php _e('Required Field','data-storage'); ?> <i> (<?php _e('required fields will be marked by * in the form','data-storage'); ?>)</i><br><br></span>
        <p class="user_guide"></p>
        <div class="field_ext">
            <i><?php _e('You can have up to 10 values for this field','data-storage'); ?> :</i><br>
            <?php
            $options = explode(" | ", $field['field_ext']);
            for($i=0;$i<=9;$i++){
                echo "<input type=\"text\" name=\"field_ext_edit_".$i."\" value=\"". (isset($options[$i])? $options[$i]: '') ."\" /><br>";
            }
            ?>
        </div>
        <p><input type="submit" name="ghazale_ds_edit_field" value="<?php _e('Update Field','data-storage'); ?>">
        <a href="<?php echo get_admin_url()?>admin.php?page=ds-forms#<?php echo $_GET['ds-edit-field-table'] ?>" style="text-decoration: none"><input type="button" value="<?php _e('Back to Forms','data-storage'); ?>"></a></p>
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
            $wpdb->update($table, array('field_name' => (isset($_POST['ghazale_ds_edit_field_name'])? trim($_POST['ghazale_ds_edit_field_name']): ''), 'field_type' => (isset($_POST['ghazale_ds_edit_field_type'])? $_POST['ghazale_ds_edit_field_type']: ''), 'field_ext'=> $output, 'field_required'=> (isset($_POST['ghazale_ds_field_required_edit'])? $_POST['ghazale_ds_field_required_edit']: '')),array('id'=>$id), array('%s'));
            $_SESSION['ds-message'] = esc_html__('Updated Successfully','data-storage');

        }else{
            $_SESSION['ds-message'] = esc_html__('Please make sure the entered Field Name is not containing disallowed symbols, and also make sure you have selected Field Type','data-storage');
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
                    $output =  "<p>" . ghazale_ds_update(). "</p>";
                    $output .= "<form action=\"\" method=\"post\" id=\"ds-form {$fields_table}\" enctype=\"multipart/form-data\">";
                    ?>
                    <script>
                        jQuery(document).ready(function($) {
                            $('input[id^=ds_reset_upload_field_]').change(function () {
                                if ($(this).get(0).files.length > 0) { // only if a file is selected
                                    var fileSize = $(this).get(0).files[0].size;
                                    var allowedSize = '<?php echo get_option('ghazale_ds_max_upload_size'); ?>';
                                    if (fileSize > allowedSize && allowedSize>0) {
                                        alert('Maximum allowed size for file upload is '+ (allowedSize/1000000) + 'MB');
                                        reset($(this));
                                    }
                                }
                            });
                            $('#submit_ghazale_ds_form').click(function(){
                                var formData = new FormData($('#ds-form')[0]);
                                $.ajax({
                                    url: '<?php echo plugins_url('ghazale_data_storage-main.php',__FILE__); ?>',  //Server script to process data
                                    type: 'POST',
                                    xhr: function() {  // Custom XMLHttpRequest
                                        var myXhr = $.ajaxSettings.xhr();
                                        if(myXhr.upload){ // Check if upload property exists
                                            myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                                        }
                                        return myXhr;
                                    },
                                    //Ajax events
                                    beforeSend: function(){
                                        $('.ds-submitting').html('Uploading...');
//                                        alert('Uploading');
                                    },
                                    success: function() {
                                        $('.ds-submitting').html('Success...');
//                                        alert('Success');
                                    },
                                    error: function(){
//                                        $('.ds-submitting').html('Failed...');
                                    },
                                    complete: function(){
                                        $('.ds-submitting').html('Results Returned');
//                                        alert('Results returned');
                                    },
                                    // Form data
                                    data: formData,
                                    //Options to tell jQuery not to process data or worry about content-type.
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            });
                            function progressHandlingFunction(e){
                                if(e.lengthComputable){
                                    $('progress').attr({value:e.loaded,max:e.total});
                                }
                            }
                        });
                    </script>
                    <?php
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
                                $output.= "<br><input type =\"text\" name= \"".$field['id']."\" size=\"30\" maxlength=\"3000\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Email":
                                $output .= "<br><input type=\"email\" name=\"".$field['id']."\" size=\"30\" maxlength=\"200\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Text Area":
                                $output .= "<br><textarea rows=\"4\" cols=\"40\" name=\"".$field['id']."\" maxlength=\"3000\" ". $required ." >". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."</textarea>" . "<br><br>";
                                break;
                            case "Number":
                                $output .= "<br><input type=\"number\" name=\"".$field['id']."\" size=\"30\" maxlength=\"3000\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Telephone":
                                $output .= "<br><input type=\"tel\" name=\"".$field['id']."\" size=\"30\" maxlength=\"50\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "URL":
                                $output .= "<br><input type=\"url\" name=\"".$field['id']."\" size=\"30\" maxlength=\"100\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" placeholder=\"". __('Should Start with http','data-storage')."\" ". $required ." />" . "<br><br>";
                                break;
                            case "Date":
                                $output .= "<br><input type=\"date\" name=\"".$field['id']."\" size=\"30\" value=\"". (isset($_POST[$field['id']])? $_POST[$field['id']] : '') ."\" ". $required ." />" . "<br><br>";
                                break;
                            case "CheckBox":
                                $output .= " <input type=\"checkbox\" name=\"".$field['id']."\" value=\"Yes\" ". $required;
                                if(isset($_POST[$field['id']]) && $_POST[$field['id']] == "Yes"){
                                    $output .= " checked";
                                }
                                 $output .= "/>" . "<br><br>";
                                break;
                            case "File Upload":
                                $output .= "<br><input type=\"file\" class=\"ds_file\" id=\"ds_reset_upload_field_".$field['id']."\" ". "name=\"ds_file_".$field['id']."\" ". $required ." /><input type=\"button\" class=\"ds_reset_upload_field_".$field['id']."\" value=\"".__('Clear','data-storage')."\" style=\"background: transparent; color: #404040; text-decoration: underline\"/>" . "<br><br>";
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
                                        if(isset($_POST[$field['id']]) && $_POST[$field['id']] == $field_option){
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
                                        $output .= "<option value='" . $field_option . "'";
                                        if(isset($_POST["ds_multiplechoice_".$field['id']])) {
                                            foreach ($_POST["ds_multiplechoice_" . $field['id']] as $multiple) {
                                                if ($multiple == $field_option) {
                                                    $output .= " selected";
                                                }
                                            }
                                        }
                                        $output .=">" . $field_option . "</option>";
                                    }
                                }
                                $output .= "</select>". "<br>";
                                $output .= "<i>".__('Hold down the Ctrl (windows) / Command (Mac) button to select multiple options','data-storage')."</i><br><br>";
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
                    $output .= "<input type=\"submit\" id=\"submit_ghazale_ds_form\" name=\"submit_" . $fields_table . "\" value=\"";
                    if(get_option('ghazale_ds_submit_button_word')){
                        $output .= get_option('ghazale_ds_submit_button_word');
                    }else{
                        $output .= __('Submit','data-storage');
                    }
                    $output .="\" >";

                    $output .= "</form>";
                    $output .= "<p><progress></progress> <span class=\"ds-submitting\"></span></p>";
                    return $output;


                }
            }
        }
    }
}
add_shortcode('data-storage','ghazale_ds_frontend_forms_shortcode');

/**
 * registering reset file input functionality
 */
function ghazale_ds_reset_file_upload_field(){
    wp_enqueue_script('ds-reset-file-input',plugins_url('js/ds-reset-file-input.js',__FILE__),array('jquery'));
}
add_action('wp_enqueue_scripts','ghazale_ds_reset_file_upload_field');
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
                            if($field['field_required'] == "Required" && isset($_POST[$field['id']]) && empty($_POST[$field['id']]) && $field['field_type'] != "Multiple Choice" && $field['field_type'] != "File Upload"){
                                array_push($empty_required,"required");
                            }elseif($field['field_required'] == "Required" && $field['field_type'] == "Multiple Choice") {

                                if(empty($_POST['ds_multiplechoice_'.$field['id']])){
                                    array_push($empty_required,"required");
                                }

                            }elseif(isset($_POST[$field['id']]) && !alphanumericAndSpace($_POST[$field['id']])){
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
                                    if (isset($_FILES["ds_file_{$field['id']}"]) && $_FILES["ds_file_{$field['id']}"]['size']>0) {
                                        if (!function_exists('wp_handle_upload')) {
                                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                                        }
                                        $uploadedfile = $_FILES["ds_file_{$field['id']}"];
                                        $upload_overrides = array('test_form' => false);
                                        if(!function_exists('ghazale_ds_change_upload_dir')) {
                                            function ghazale_ds_change_upload_dir($upload)
                                            {
                                                global $wpdb;
                                                $table_name = $wpdb->prefix . "ghazale_ds_";
                                                $tables = $wpdb->get_results("SHOW TABLES LIKE " . "'" . $table_name . "%_fields'", ARRAY_A);
                                                foreach ($tables as $table) {
                                                    foreach ($table as $fields_table) {
                                                        if (isset($_POST['submit_' . $fields_table])) {
                                                            $new_dir = '/data-storage-' . str_replace(array($table_name, '_fields'), '', $fields_table);
                                                        }
                                                    }
                                                }

                                                $upload['path'] = str_replace($upload['subdir'], '', $upload['path']);
                                                $upload['url'] = str_replace($upload['subdir'], '', $upload['url']);
                                                $upload['subdir'] = $new_dir;
                                                $upload['path'] .= $new_dir;
                                                $upload['url'] .= $new_dir;

                                                return $upload;
                                            }
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
                                $wpdb->insert($input_table, array('field_id' => $field['id'], 'field_input' => (isset($_POST[$field['id']])? $_POST[$field['id']]: '')), array('%s'));
                                $_SESSION["ds-update"] = esc_html__('Entry Submitted!','data-storage');

                                if($field['field_type'] != "Multiple Choice" && $field['field_type'] != "File Upload"){
                                    if($field['field_type'] == "Email"){
                                        $user_email = $_POST[$field['id']];
                                    }
                                    $new_entry[$field['field_name']] = (isset($_POST[$field['id']])? $_POST[$field['id']]: '');
                                }elseif($field['field_type'] == "Multiple Choice" && !empty($_POST["ds_multiplechoice_".$field['id']])){
                                    $new_entry[$field['field_name']] = implode(" | ", $multiple_choice);
                                }elseif($field['field_type'] == "File Upload" && !empty($movefile)){
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
                            $_SESSION["ds-error"] = esc_html__('All required fields should be filled. Required fields are marked with (*)','data-storage');
                        } elseif(!empty($not_alphanumeric)) {
                            $_SESSION["ds-error"] = esc_html__('Some Symbols are not allowed for security. Please reconsider your entries. Allowed symbols are: @-_.,\/:()','data-storage');
                        }
                    }else{
                        $_SESSION["ds-error"] = esc_html__('The entered captcha is incorrect. Please enter the correct value.','data-storage');
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
                echo "<p><input type=\"button\" name=\"ds_download_table_csv\" class=\"ds_download_table_csv_".$table."\" value=\"".__('Download Table In CSV Format','data-storage')."\" /><i>". __('After you downloaded the table, rename the file and put .csv at the end of the file name.','data-storage') ."</i></p>";
                echo "<table class = \"table\" id=\"ds_download_table_csv_".$table."\">";
                $inputs_sql = "SELECT * FROM " . $table. " ORDER BY id ASC";
                $inputs = $wpdb->get_results($inputs_sql, ARRAY_A);

                foreach($field_tables as $field_table){
                    foreach($field_table as $field_table_single){
                        if($field_table_single == str_replace("_inputs","_fields","$table")){
                            $fields_sql = "SELECT id,field_name,field_type FROM ". $field_table_single;
                            $fields = $wpdb->get_results($fields_sql,ARRAY_A);
                            if(!empty($inputs)){
                                $instructions_field_id = array();
                                echo "<tr>";
                                foreach($fields as $field){
                                    if($field['field_type'] != 'Instruction Text') {
                                        echo "<th>" . $field['field_name'] . "</th>";
                                    }else{
                                        array_push($instructions_field_id, $field['id']);
                                    }
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
                                    if(!in_array($input['field_id'], $instructions_field_id)) {
                                        foreach ($input as $key => $input_single) {
                                            if ($input_single != "" && $key != 'id' && $key != 'field_id') {
                                                if (substr($input_single, 0, 4) === "http") {
                                                    echo "<td><a href='" . $input_single . "' target='_blank'>" . $input_single . "</a></td>";
                                                } else {
                                                    echo "<td>" . $input_single . "</td>";
                                                }
                                            } elseif ($input_single == "") {
                                                echo "<td> </td>";
                                            }
                                        }
                                    }
                                    if($input['field_id'] == $last_id) {
                                        echo "</tr>";
                                    }
                                }

                            }else{
                                    echo __('There is no input','data-storage');
                            }
                        }
                    }
                }
                echo "</table>";
                echo "<p><a href=\"" . get_admin_url() . "admin.php?page=ds-form-entries&ds-del-data-input-table=" . $table . "#". $table."\" style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"".__('Delete All Data in This Input Table','data-storage')."\"></a></p>";
                echo "<p><a href=\"" . get_admin_url() . "admin.php?page=ds-form-entries&ds-total-del-input-table-and-corresponding-form-table=" . $table . "\" style=\"text-decoration: none\" onclick=\"return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');\"><input type=\"button\" value=\"".__('Totally Delete This Input Table AND Its Corresponding Form','data-storage')."\"></a></p>";
                echo "</div>";
            }

        }
        echo "</div>";
    }else{
        echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"> <strong>".__('No inputs to display. Once you had inputs from your form, they will appear on this page in an organized table.','data-storage')."</strong></div>";
    }
}
function ghazale_ds_form_inputs_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage',__('Inputs','data-storage'),__('Inputs','data-storage'),'manage_options','ds-form-entries','ghazale_ds_form_inputs');
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
                    $_SESSION['ds-message'] = '<strong>'.esc_html__('Deleted Successfully','data-storage').'.</strong> '.esc_html__('Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.','data-storage');
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
                    $_SESSION['ds-message'] = '<strong>'.esc_html__('Deleted Successfully','data-storage').'.</strong> '.esc_html__('Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.','data-storage');
                }
            }
        }
        $field_tables = $wpdb->get_results("SHOW TABLES LIKE "."'" .$tables."%_fields'",ARRAY_A);
        $form = str_replace("_inputs","_fields",$_GET['ds-total-del-input-table-and-corresponding-form-table']);
        foreach($field_tables as $field_table){
            foreach($field_table as $form_table){
                if($form_table == $form){
                    $wpdb->query("DROP TABLE IF EXISTS ". $form);
                    $_SESSION['ds-message'] = '<strong>'.esc_html__('Deleted Successfully','data-storage').'.</strong> '.esc_html__('Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.','data-storage');
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
        <h3><?php _e('Captcha and Submit Button Value','data-storage'); ?></h3>
            <div>
        <h4><?php _e('Captcha','data-storage'); ?></h4>
        <input type="checkbox" name="ghazale_ds_add_captcha" id="ghazale_ds_add_captcha" value="1" <?php
        checked(get_option('ghazale_ds_add_captcha'), 1);
        ?>/> <?php _e('I want to add captcha to my forms.','data-storage'); ?> <i> <?php _e('(for fighting against spams and spam bot)','data-storage'); ?></i> <br><br>
        <?php _e('Add Custom Captcha Message','data-storage'); ?>: <br>
        <textarea rows="4" cols="40" name="ghazale_ds_custom_captcha_msg"><?php
        if(get_option('ghazale_ds_custom_captcha_msg')){
            echo get_option('ghazale_ds_custom_captcha_msg');
        } else{
            echo __('Prove you are not a robot!','data-storage');
        }
        ?></textarea><br><br>
        <h4><?php _e('Submit Button Value','data-storage'); ?></h4>
        <?php _e('Change the word on "Submit" button to whatever you want.','data-storage'); ?><br>
        <?php _e('Submit Button Word','data-storage'); ?>: <input type="text" name="ghazale_ds_submit_button_word" value="<?php
        if(get_option('ghazale_ds_submit_button_word')){
            echo get_option('ghazale_ds_submit_button_word');
        } else{
            echo "Submit";
        }
        ?>"/><br><br>
            </div>
        <h3><?php _e('Maximum allowed size for file uploads','data-storage'); ?></h3>
            <div>
                <?php _e('Maximum allowed size for upload fields', 'data-storage'); ?>:<input type="text" placeholder="5000000" size="30" name="ghazale_ds_max_upload_size" value="<?php echo get_option('ghazale_ds_max_upload_size'); ?>" /><br><i> <?php _e('Write the size in "Byte" metric. (Example: If the maximum allowed upload size is 5Mb, then put 5000000 in this field)','data-storage'); ?></i>
            </div>
        <h3><?php _e('Page Redirection','data-storage'); ?></h3>
            <div>
        <?php _e('Custom Thank You/Confirmation Page Redirection.','data-storage'); ?><br>
        <?php _e('Redirection Page URL','data-storage'); ?>: <input type="url" placeholder="<?php _e('Should start with http','data-storage'); ?>" size="30" name="ghazale_ds_page_redirection" value="<?php echo get_option('ghazale_ds_page_redirection'); ?>" /><i> <?php _e('If you do not wish to redirect user, leave it blank.','data-storage'); ?></i><br><br>
            </div>
        <h3><?php _e('Confirmation Email','data-storage'); ?></h3>
            <div>
        <input type="checkbox" name="ghazale_ds_confirmation_email" value="1" <?php
        checked(get_option('ghazale_ds_confirmation_email'), 1);
        ?>/> <?php _e('Send confirmation Email to user.','data-storage'); ?><br><br>
        <?php _e('From','data-storage'); ?>: <input type="email" name="ghazale_ds_confirmation_from" value="<?php
        if(get_option('ghazale_ds_confirmation_from')) {
            echo get_option('ghazale_ds_confirmation_from');
        }else{
            echo get_option('admin_email');
        }
        ?>"/><i> <?php _e('This is the email that user will see when they receive confirmation/thank you email','data-storage'); ?></i><br><br>
        <?php _e('Message','data-storage'); ?>: <i> <?php _e('(Confirmation/ Thank you Email Message)','data-storage'); ?></i><br>
        <textarea name="ghazale_ds_confirmation_msg" rows="5" cols="40" ><?php echo get_option('ghazale_ds_confirmation_msg'); ?></textarea><br><br>
            </div>
        <h3><?php _e('Inform Admin','data-storage'); ?></h3>
            <div>
        <input type="checkbox" name="ghazale_ds_update_admin" value="1" <?php
        checked(get_option('ghazale_ds_update_admin'), 1);
        ?> /> <?php _e('Inform admin when new entry is submitted','data-storage'); ?> <br><br>
        <?php _e('Admin Email','data-storage'); ?> : <input type="email" name="ghazale_ds_update_admin_email" value="<?php
        if(get_option('ghazale_ds_update_admin_email')) {
            echo get_option('ghazale_ds_update_admin_email');
        }else{
            echo get_option('admin_email');
        }
        ?>" /><br><br>
            </div>
        </div>
        <br>
        <input type="submit" name="ghazale-ds-submit-general_settings" value="<?php _e('Save Settings','data-storage'); ?>">
    </form>
<?php
}
function ghazale_ds_general_settings_admin_menu(){
    $page_suffix = add_submenu_page('ds-data-storage',__('General Settings','data-storage'),__('General Settings','data-storage'),'manage_options','ds-general-settings','ghazale_ds_general_settings');
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
/**
 * loading language file
 */
function ghazale_ds_load_plugin_textdomain() {
    load_plugin_textdomain( 'data-storage', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ghazale_ds_load_plugin_textdomain' );