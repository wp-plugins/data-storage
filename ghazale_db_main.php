<?php
/*
Plugin Name: Data Storage
Plugin URI: https://github.com/ghsh88/ghazale/releases/tag/v1.0.0
Description: Fully customizable,searchable,editable database table. Equipped with instant data search in the backend of your website, instant feedback to user upon submitting the form. Perfect for collecting people's information, inquiries and many other purposes. In addition of having the data in the backend, you also have the option to receive the details of the submitted data, right in your email as well. There's also the option to send Thank you/Confirmation email to the user with customized text and address as well as many other features.
Author: Ghazale Shirazi
Version: 1.0.1
Author URI: https://github.com/ghsh88


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

require_once("message_session.php");
// number of the form fields
$field_count = 20;
$subfield_count = 10;
/**
 * below function creates a database table upon plugin activation
 */
function ghazaledb_create_table(){

    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    if($wpdb->get_var('SHOW TABLES LIKE ' . $table_name) !=$table_name){
        $sql = "CREATE TABLE {$table_name} (id INTEGER(10) UNSIGNED AUTO_INCREMENT, submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ";
        $sql .= "field_1 VARCHAR(255),field_2 VARCHAR(255),field_3 VARCHAR(255),field_4 VARCHAR(255),field_5 VARCHAR(255),field_6 VARCHAR(255),field_7 VARCHAR(255),field_8 VARCHAR(255),field_9 VARCHAR(255),field_10 VARCHAR(255),field_11 VARCHAR(255),field_12 VARCHAR(255),field_13 VARCHAR(255),field_14 VARCHAR(255),field_15 VARCHAR(255),field_16 VARCHAR(255),field_17 VARCHAR(255),field_18 VARCHAR(255),field_19 VARCHAR(255),field_20 VARCHAR(255),";
        $sql .= " PRIMARY KEY  (id) )";

        $wpdb->query($sql);
        add_option('ghazaledb_database_version','1.0');
    }
}

register_activation_hook(__FILE__, 'ghazaledb_create_table');


/**
 * @return string
 * following function shows the form on front end
 */


function ghazaledb_form_shortcode()
{
    $path = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION['redirect_uri'] = $path;
    global $field_count;
    global $subfield_count;
    $update_message = "<div style='background-color: #04a4cc; color: #fff'>" . update_message() . "</div>";
    $output = $update_message . "<form action = \"\" method = \"post\" enctype=\"multipart/form-data\" id=\"ghazaledb-database-form\">";
    for ($count = 1; $count <= $field_count; $count++) {
        for ($count = 1; $count <= $field_count; $count++) {
            if (trim(get_option("ghazaledb_field_{$count}")) != "") {
                if (get_option("ghazaledb_field_required_{$count}")) {
                    $output .= esc_attr(get_option("ghazaledb_field_{$count}")) . "*";
                    $required = "required";
                } else {
                    $output .= esc_attr(get_option("ghazaledb_field_{$count}"));
                    $required = "";
                }

                switch (get_option("ghazaledb_type_{$count}")) {
                    case "Text Field{$count}":
                        $output .= "<br><input type=\"text\" id=\"ghazaledb_form_textfield_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\"  size=\"30 \" " . $required . "/></br></br>";
                        break;
                    case "Text Area{$count}":
                        $output .= "<br><textarea rows=4 cols=40 id=\"ghazaledb_form_textarea_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" ></textarea></br></br>";
                        break;
                    case "Number{$count}":
                        $output .= "<br><input type=\"number\" id=\"ghazaledb_form_number_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" size=\"30 \" min=\"0\" value=\"0\" " . $required . "/></br></br>";
                        break;
                    case "Email{$count}":
                        $output .= "<br><input type=\"email\" id=\"ghazaledb_form_email_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" size=\"30 \" " . $required . "/></br></br>";
                        break;
                    case "Telephone{$count}":
                        $output .= "<br><input type=\"tel\" id=\"ghazaledb_form_tel_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" size=\"30 \" " . $required . "/></br></br>";
                        break;
                    case "URL{$count}":
                        $output .= "<br><input type=\"url\" id=\"ghazaledb_form_url_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" size=\"30 \" " . $required . " placeholder=\"Should Start with http\"/></br></br>";
                        break;
                    case "Date{$count}":
                        $output .= "<br><input type=\"date\" id=\"ghazaledb_form_date_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" size=\"30 \" " . $required . "/></br></br>";
                        break;
                    case "CheckBox{$count}":
                        $output .= " <input type=\"checkbox\" id=\"ghazaledb_form_checkbox_" . $count . "\" name=\"ghazaledb_form_input_" . $count . "\" value=\" Yes\" " . $required . "/></br></br>";
                        break;
                    case "Drop Down{$count}":
                        $output .= "<br><select name=\"ghazaledb_form_input_" . $count . "\" " . $required . ">";
                        for ($i = 1; $i <= $subfield_count; $i++) {
                            if (trim(get_option("ghazaledb_dropdown_" . $count . "_" . $i) != "")) {
                                if ($i == 1) {
                                    $output .= "<option value=\"\" >-- Select --</option>";
                                }
                                $output .= "<option value=\"" . get_option("ghazaledb_dropdown_" . $count . "_" . $i) . "\">" . get_option("ghazaledb_dropdown_" . $count . "_" . $i) . "</option>";
                            }
                        }
                        $output .= "</select><br><br>";

                        break;
                    case "Multiple Choice{$count}":
                        $output .= "<br><select name=\"ghazaledb_form_input_" . $count . "[]\" " . $required . " multiple>";
                        for ($i = 1; $i <= $subfield_count; $i++) {
                            if (trim(get_option("ghazaledb_multiple_" . $count . "_" . $i) != "")) {
                                $output .= "<option value=\"" . get_option("ghazaledb_multiple_" . $count . "_" . $i) . "\">" . get_option("ghazaledb_multiple_" . $count . "_" . $i) . "</option>";
                            }
                        }
                        $output .= "</select><br>";
                        $output .= "<i>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</i><br><br>";

                        break;
                    case "File Upload{$count}":
                        $output .= "<br><input type=\"file\" id=\"ghazaledb_file_upload_". $count ."\" name=\"file_".$count."\" " . $required . " accept=\"".get_option("ghazaledb_accept_upload_{$count}")."\">"."<br>";
                        break;

                    case "Instruction Text{$count}":
                        $output .= "<br>";
                        break;
                    default:
                        break;
                }
            }
        }
    }
    $output .= '<br><p><input type="submit" name="submit" value="Submit" /></p></form>';
    return $output;
}

add_shortcode('ds-gdb','ghazaledb_form_shortcode');

/**
 * following function shows database table in admin page
 */
function ghazaledb_table_page(){
    global $field_count;
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    ?>
    <h2 xmlns="http://www.w3.org/1999/html">Database Table</h2>
    <?php
    $sql = 'SELECT * FROM ' . $table_name . ' ORDER BY id ASC';
    $results = $wpdb->get_results($sql, ARRAY_A);

    ?>

    <h4><?php echo update_message(); ?></h4>

    <table style="display: inline-block">
        <form action="" method="post" id="bulk_action" name="bulk_action" >
            <tr><td> <select class="select_bulk_action" name="select_bulk_action">
                        <option value="Select Bulk Action">-- Bulk Actions --</option>
                        <option value="Bulk Delete">Bulk Delete</option>
                    </select>
                    <input type="submit" class="bulk_action" name="bulk_action" value=" Apply "/></td></tr></form>
    </table>

    <?php

    for ($count=1;$count<=$field_count;$count++){
        if(get_option("ghazaledb_type_{$count}") == "Email{$count}"){
            ?>
            <br><a href ="<?php echo get_admin_url();?>admin.php?page=ghazaledb-extract-email" style="text-decoration:none" ><input type="button" value=" Extract All Emails " style="float: right" /></a><br><br>
        <?php
        }
    }
    ?>

    <table id="data_table" class="display">
        <thead>
        <tr>

            <?php
            for ($count=1;$count<=$field_count;$count++) {
                if(trim(get_option("ghazaledb_field_{$count}")) != "" ) {

                    if ((get_option("ghazaledb_field_{$count}"))) {
                        if($count==1){
                            ?>
                            <th align="left"><input type="checkbox" id="ghazaledb_deletion_checkbox" /></th>
                            <th></th>
                            <th></th>
                            <th>ID</th>
                            <th>Date|Time</th>

                        <?php
                        }
                        ?>
                        <th>
                        <?php
                        if(get_option("ghazaledb_type_{$count}") != "Instruction Text{$count}"){
                            echo esc_attr(get_option("ghazaledb_field_{$count}"));
                        }
                    }
                    ?>
                    </th>
                <?php
                }else{
                    echo "<th></th>";
                }
            }

            ?>
        </tr></thead>
        <tbody>

        <?php

        foreach ($results as $result){

            ?>
            <tr>
                <?php
                ?>
                <td><input type="checkbox" class="ghazaledb_deletion_checkbox" name="deletion_checkbox[<?php echo $result['id'];?>]" value="<?php echo $result['id'];?>" form="bulk_action" /></td>
                <td><a href="<?php echo get_admin_url();?>admin.php?page=ghazaledb-edit-data&id=<?php echo $result['id']; ?>" style="text-decoration:none">
                        <input type="button" value=" Edit "></a></td>

                <td><a href="?del=<?php echo $result['id']; ?>" style="text-decoration:none"
                       onclick="return confirm('Are you sure? (THIS ACTION CANNOT BE UNDONE)');">
                        <input type="button" value=" Delete "></a></td>
                <?php

                foreach ($result as $key => $value) {

                    if (trim($value)!="" ) {
                        if(substr( $value, 0, 4 ) === "http"){
                            echo "<td><a href='".$value ."' target='_blank'>".$value."</a> </td>";
                        }else {
                            echo "<td>{$value}</td>";
                        }
                    } else{
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
<?php
}

function ghazaledb_plugin_menu(){
    $page_suffix = add_menu_page('Data Storage','Data Storage','manage_options','ghazaledb-plugin-menu','ghazaledb_table_page',plugin_dir_url(__FILE__).'/images/ic_db.png');
    add_action('admin_print_scripts-' . $page_suffix,'ghazaledb_admin_scripts');
}

add_action('admin_menu','ghazaledb_plugin_menu');


/**
 * Extracting Email from table
 */
function ghazaledb_extract_email(){
    global $field_count;
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    $assoc_emails=array();
    for($count=1;$count<=$field_count;$count++){
        if(get_option("ghazaledb_type_{$count}") == "Email{$count}") {
            $results = $wpdb->get_results("SELECT field_{$count} from {$table_name}", ARRAY_A);
            array_push($assoc_emails,$results);
        }
    }

    ?>
    <h3>Emails</h3>
    <a href="<?php echo get_admin_url();?>admin.php?page=ghazaledb-plugin-menu" style="text-decoration:none"><input type="button" value=" Back to Table "></a>
    <?php
    foreach($assoc_emails as $emails){
        ?>
        <h4>
            <?php
            foreach($emails as $email){
                foreach($email as $data) {
                    if(!empty($data)) {
                        echo $data . ",<br>";
                    }
                }
            }
            ?>
        </h4>
    <?php
    }
}

function ghazaledb_extract_email_menu(){
    add_submenu_page(null,'Extract Email','Extract Email','manage_options','ghazaledb-extract-email','ghazaledb_extract_email');
}

add_action('admin_menu','ghazaledb_extract_email_menu');

/**
 * below function is for updating the data values that are already submitted
 * and showing in the table
 */
function ghazaledb_edit_data(){
    global $field_count;
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    ?>
    <h3>Edit Data</h3>
    <?php

    for ($count = 1; $count <= $field_count; $count++) {
        $id = $_GET['id'];

        If ($count==1){
            echo "ID: " . $_GET['id'] . "<br><br>";
        }
        ?>
        <form action="<?php echo get_admin_url(); ?>admin.php?edit=<?php echo $id; ?>"
        method="post" id="ghazale_db_update">
        <?php
        if (trim(get_option("ghazaledb_field_{$count}"))) {
            if(get_option("ghazaledb_type_{$count}") !="Instruction Text{$count}") {
                echo esc_attr(get_option("ghazaledb_field_{$count}")) . "</br>";
            }
            $sql = "SELECT field_{$count} FROM {$table_name} WHERE id={$_GET['id']}";
            $field_value = $wpdb->get_var($sql);
            if(get_option("ghazaledb_type_{$count}") == "Instruction Text{$count}"){

            }elseif (get_option("ghazaledb_type_{$count}") == "Text Area{$count}") {
                echo "<textarea rows=4 cols=50 id=\"ghazaledb_update_textarea_" . $count . "\" name=\"ghazaledb_update_textarea_" . $count .
                    "\">" . $field_value . "</textarea></br></br>";
            } else {
                echo "<input type=\"text\" id=\"ghazaledb_update_textfield_" . $count . "\" name=\"ghazaledb_update_textfield_" . $count .
                    "\" value = \"" . $field_value . "\" /></br></br>";
            }
        }
    }
    echo '<input type="submit" id="ghazaledb_edit_submit" name="ghazaledb_edit_submit" value="Update"></form>';
    echo "<br><a href = \"" . get_admin_url() . "admin.php?page=ghazaledb-plugin-menu\"><input type=\"button\" value = \"Back to Table\"/></a>";

}

function ghazaledb_edit_page_menu(){
    add_submenu_page(null,'Edit Data','Edit Data','manage_options','ghazaledb-edit-data','ghazaledb_edit_data');
}

add_action('admin_menu','ghazaledb_edit_page_menu');


/**
 * following function registers the settings in options page
 */

function ghazaledb_init(){
    global $field_count;
    global $subfield_count;
    for ($count =1 ; $count<=$field_count; $count++){
        register_setting("ghazaledb_options_group","ghazaledb_field_{$count}");
        register_setting("ghazaledb_options_group","ghazaledb_type_{$count}");
        register_setting("ghazaledb_options_group","ghazaledb_field_required_{$count}");
        register_setting("ghazaledb_options_group","ghazaledb_accept_upload_{$count}");

    }

    register_setting('ghazaledb_options_group','ghazaledb_successful_redirect');
    register_setting('ghazaledb_options_group','ghazaledb_inform_submission');
    register_setting('ghazaledb_options_group','ghazaledb_inform_email');
    register_setting('ghazaledb_options_group','ghazaledb_confirm_email_user');
    register_setting('ghazaledb_options_group','ghazaledb_confirm_msg_user');
    register_setting('ghazaledb_options_group','ghazaledb_from_confirm_email');

    for ($count =1 ; $count<=$field_count; $count++){
        for($i=1; $i<=$subfield_count; $i++){
            register_setting("ghazaledb_options_group","ghazaledb_dropdown_".$count. "_" . $i);
            register_setting("ghazaledb_options_group","ghazaledb_multiple_".$count. "_" . $i);
        }
    }


}
add_action('admin_init','ghazaledb_init');


/**
 * following function shows elements in the options page
 */
function ghazaledb_options_page(){
    global $field_count;
    global $subfield_count;
    ?>


    <form action="options.php" method="post" id="ghazaledb_optionsform">

    <?php settings_errors(); ?>

    <?php settings_fields('ghazaledb_options_group'); ?>
    <table id="guide">
    <tr><th>Guide Notes</th></tr>
    <tr><td><i><ol><li>After you saved the options,just put the shortcode <strong>[ds-gdb]</strong> on the desired page to see the form.</li>
    <li>Fill the fields <strong>In Sequence</strong>, because the datas are being inserted to database in number sequence and will be displayed in the same sequence as well </li>
    <li>If you ever had a question or problem or maybe wanted some modifications to this plugin, just <a href="mailto:ghsh88@gmail.com">drop me a line</a> :)</li>
    </ol></i></td></tr></table>

        <br><input type="submit" name="submit_options" value="Save Settings"><br>
        <div id="accordion">
        <h3>Set Up Form Fields</h3>
        <div class="overflow"><div><p>

        <table id="fields_table" style="width : 70%">
            <tr>
                <th></th>
                <th>Field Name</th>
                <th>Type</th>
                <th>Required</th>
            </tr>

        <?php

    for($count=1; $count<=$field_count; $count++){
        ?>
        <tr><td valign="top"><div class="row_number"> <?php echo $count; ?></div></td>

            <td valign="top"><input type="text" class="ghazaledb_field" id="ghazaledb_field" name="<?php echo "ghazaledb_field_{$count}"; ?>"
                                    value="<?php echo get_option("ghazaledb_field_{$count}"); ?>" size="30"/>
                <div class="ghazaledb_accept_upload">
                    <span style="color: #FF9900"><i>Accepted Type of files</i></span>
                    <br><input type="text" name="<?php echo "ghazaledb_accept_upload_{$count}" ?>"  value="<?php echo get_option("ghazaledb_accept_upload_{$count}"); ?>" placeholder="ex: .jpg, .png, .pdf" />
                </div>
                <div class="drop_down">
                    <span style="color: #FF9900"><i>Drop Down values</i></span>
                    <?php
                    for($i=1 ; $i<=$subfield_count; $i++) {
                        ?>
                        <br><input type="text" name="<?php echo "ghazaledb_dropdown_".$count . "_" . $i ?>"
                                   value="<?php echo get_option("ghazaledb_dropdown_".$count . "_" . $i); ?>"/>
                    <?php
                    }
                    ?>
                </div>

                <div class="multiple_choice">
                    <span style="color: #FF9900"><i>Multiple Choice values</i></span>
                    <?php
                    for($i=1 ; $i<=$subfield_count; $i++) {
                        ?>
                        <br><input type="text" name="<?php echo "ghazaledb_multiple_".$count . "_" . $i ?>"
                                   value="<?php echo get_option("ghazaledb_multiple_".$count . "_" . $i); ?>"/>
                    <?php
                    }
                    ?>
                </div>
            </td>


            <td valign="top"> <select class="ghazaledb_type" id="<?php echo "ghazaledb_type_{$count}"; ?>" name="<?php echo "ghazaledb_type_{$count}"; ?>">

                    <?php $type_array = array("Text Field{$count}","Text Area{$count}","Drop Down{$count}","Multiple Choice{$count}","Email{$count}","File Upload{$count}","Number{$count}","Telephone{$count}","URL{$count}","Date{$count}","CheckBox{$count}","Instruction Text{$count}"); ?>
                    <?php

                    foreach($type_array as $type) {

                        echo "<option value = \"{$type}\"";
                        if (get_option("ghazaledb_type_{$count}") == $type) {
                            echo " selected";
                        }
                        echo ">" . str_replace($count,"",$type) ."</option>";

                    }
                    ?>
                </select></td>
            <td valign="top"><input type="checkbox" class="ghazaledb_field_required"
                                    id="ghazaledb_field_required"
                                    name="<?php echo "ghazaledb_field_required_{$count}"; ?>" value="1"
                    <?php checked(get_option("ghazaledb_field_required_{$count}"), 1); ?>/></td>


        </tr>

    <?php
    }

    ?>
    </table>
    </p></div></div>



        <h3>Send Confirmation Email to User</h3>
       <div><p> <input type="checkbox" id="ghazaledb_confirm_email_user" name="ghazaledb_confirm_email_user" value="1"
        <?php checked(get_option('ghazaledb_confirm_email_user'),1); ?>/> Send confirmation Email to user.</p>
        <p id="note"></p>
        From: <input type="email" id="ghazaledb_from_confirm_email" name="ghazaledb_from_confirm_email"
        value="<?php if(get_option('ghazaledb_from_confirm_email')){
        echo get_option('ghazaledb_from_confirm_email');
    }else{
        echo get_option('admin_email');
    }
    ?>"/> <i>Write the email address that you want the user to see when recieveing the confirmation email.</i>
        <p>
        Message: <br>
        <textarea rows=4 cols=40 id="ghazaledb_confirm_msg_user" name="ghazaledb_confirm_msg_user"><?php echo get_option('ghazaledb_confirm_msg_user') ?></textarea>
</p>
</div>


        <h3>Custom Thank You Page Redirection</h3>
       <div>  <p>Custom Thank You Page URL: <input type="url" id="ghazaledb_successful_redirect" name="ghazaledb_successful_redirect"
                                           value="<?php echo get_option('ghazaledb_successful_redirect'); ?>" placeholder="Enter URL"/></p>
        <p></div>


        <h3>Update Admin</h3>
        <div>
        <input type="checkbox" id="ghazaledb_inform_email" name="ghazaledb_inform_email" value="1"
        <?php checked(get_option('ghazaledb_inform_email'),1); ?>/> Update Admin About Recent Submission Details

        <p> Email: <input type="email" id="ghazaledb_inform_submission" name="ghazaledb_inform_submission" value="<?php if(get_option('ghazaledb_inform_submission')){
        echo get_option('ghazaledb_inform_submission');
    }else{
        echo get_option('admin_email');
    }
    ?>"/><i>Enter your desired email to be updated once a form is submitted.</i></p>
    </div>
</div>
        <br><input type="submit" name="submit_options" value="Save Settings">


    </form>

<?php

}

/**
 * JS for admin elements
 */
function ghazaledb_admin_init(){
    wp_register_script('ghazaledb-script',plugins_url('/js/ghazaledb.js',__FILE__),array("jquery","jquery-ui-core","jquery-ui-accordion"));
    wp_register_style('ghazaledb-style',plugins_url('/css/jquery-ui.css',__FILE__));
    wp_register_script('data-table-script',plugins_url('/js/jquery.dataTables.js',__FILE__),array("jquery"));
    wp_register_style('data-table-style',plugins_url('/css/jquery.dataTables.css',__FILE__));

}
add_action('admin_init','ghazaledb_admin_init');

function ghazaledb_options_submenu(){
    $page_suffix = add_submenu_page('ghazaledb-plugin-menu','Options','Options','manage_options','ghazaledb-options-submenu','ghazaledb_options_page');
    add_action('admin_print_scripts-' . $page_suffix,'ghazaledb_admin_scripts');
    add_action('admin_print_styles-' . $page_suffix, 'ghazaledb_admin_scripts');
}
add_action('admin_menu','ghazaledb_options_submenu');

function ghazaledb_admin_scripts(){
    wp_enqueue_script('ghazaledb-script');
    wp_enqueue_style('ghazaledb-style');
    wp_enqueue_script('data-table-script');
    wp_enqueue_style('data-table-style');
}


/**
 * Handling the insertion of data into the custom database table
 */

function ghazaledb_insert_into_database() {
    global $field_count;
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";

    $sql_old = 'SELECT * FROM '. $table_name .' ORDER BY id ASC';
    $old_wpdb = $wpdb->query($sql_old);

    $assoc = array();
    $required = array();
    $multiple_choice= array();
    for($count=1;$count<=$field_count;$count++) {
        if (get_option("ghazaledb_type_{$count}") != "Multiple Choice{$count}") {
            $assoc["field_" . $count] = stripcslashes(trim($_POST["ghazaledb_form_input_" . $count]));
        }
        if (get_option("ghazaledb_field_required_{$count}") && trim($_POST["ghazaledb_form_input_" . $count] == "") && get_option("ghazaledb_type_{$count}") != "File Upload{$count}") {
            array_push($required, "required");
        }

        if (get_option("ghazaledb_type_{$count}") == "Multiple Choice{$count}" && $_POST["ghazaledb_form_input_{$count}"]) {
            foreach ($_POST["ghazaledb_form_input_{$count}"] as $multiple) {
                array_push($multiple_choice, $multiple);
            }
            if (get_option("ghazaledb_field_required_{$count}") && count($multiple_choice) == 0) {
                array_push($required, "Multiple Choice Empty");
            }
            $choices = implode(" | ", $multiple_choice);
            $assoc["field_" . $count] = $choices;
        }

        if ($_FILES["file_{$count}"]['size'] > 0) {
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $uploadedfile = $_FILES["file_{$count}"];

            $upload_overrides = array('test_form' => false);

            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
//                echo "File is valid, and was successfully uploaded.\n";
//                var_dump($movefile);
                $assoc["field_".$count] = $movefile['url'];
            } else {
                /**
                 * Error generated by _wp_handle_upload()
                 * @see _wp_handle_upload() in wp-admin/includes/file.php
                 */
                $_SESSION['message'] = $movefile['error'];
            }
        }
    }

    if(count($required) != 0){
        $_SESSION['message'] = "Please fill all the required fields. </br>";
    }else {
        $wpdb->insert($table_name, $assoc, array('%s'));
    }

    /**
     * compares the number of old rows and the new rows after data insertion.
     * this is for determining successful data insertion.
     */


    $sql_new = 'SELECT * FROM '. $table_name .' ORDER BY id ASC';
    $new_wpdb = $wpdb->query($sql_new);

    if($new_wpdb > $old_wpdb && isset($_POST['submit'])) {
        $_SESSION["message"] = "Entry Submitted!";

        /**
         * Send confirmation email to user
         */
        if(get_option('ghazaledb_confirm_email_user')){
            for($count=1;$count<=$field_count;$count++){
                if(get_option("ghazaledb_type_{$count}") == "Email{$count}"){
                    $confirm_to =  trim($_POST["ghazaledb_form_input_" . $count]);
                }
            }

            $confirm_subject="Your recent submission on " . get_bloginfo('name');
            $confirm_message = get_option('ghazaledb_confirm_msg_user');

            $confirm_headers = 'From:' . get_bloginfo('name') .' <'. get_option('ghazaledb_from_confirm_email') .'>' . "\r\n";
            wp_mail($confirm_to,$confirm_subject,$confirm_message,$confirm_headers);
        }

        /**
         * Send email to admin
         */
        if(get_option('ghazaledb_inform_email')){
            if(get_option('ghazaledb_inform_submission')){
                $output_email =  get_option('ghazaledb_inform_submission');
            }else{
                $output_email = get_option('admin_email');
            }
            $to = $output_email;
            $subject = "New Submission at your Website " . get_bloginfo('name');


            for($count=1;$count<= $field_count; $count++){
                if(trim(get_option("ghazaledb_field_{$count}")) != "" && get_option("ghazaledb_type_{$count}") != "Multiple Choice{$count}" && get_option("ghazaledb_type_{$count}")!= "File Upload{$count}"){
                    $latest_entry .=  esc_attr(get_option("ghazaledb_field_{$count}")) . ": " . $_POST["ghazaledb_form_input_" . $count] . "\r\n\r\n" ;
                }elseif(trim(get_option("ghazaledb_field_{$count}")) != "" && get_option("ghazaledb_type_{$count}") == "Multiple Choice{$count}"){
                    $latest_entry .= esc_attr(get_option("ghazaledb_field_{$count}")) . ": " .$choices. "\r\n\r\n" ;
                }elseif(trim(get_option("ghazaledb_field_{$count}")) != "" && get_option("ghazaledb_type_{$count}") == "File Upload{$count}"){
                    $latest_entry .= esc_attr(get_option("ghazaledb_field_{$count}")) . ": " . $movefile['url'] . "\r\n\r\n" ;
                }
            }
            $entry = $latest_entry;
            $message = "You have a new entry at your website. "
                . "\r\n\r\n\r\n\r\n". $latest_entry;

            $header = 'From:' . get_bloginfo('name') .' <'. get_option('admin_email') .'>' . "\r\n";
            wp_mail($to,$subject,$message,$header);
        }

        //redirect upon successfull submission
        if(get_option('ghazaledb_successful_redirect') && isset($_POST['submit'])) {
            wp_redirect(get_option('ghazaledb_successful_redirect'));
            exit;
        }
    }else{
        $_SESSION["message"] = "There was an error";
    }
}

/**
 * hooking wp_loaded for page redirection, so the wp_redirect function can work
 */
add_action( 'wp_loaded', 'ghazaledb_form_submitted');

/**
 * handling the form submission by calling ghazaledb_insert_into_database
 */

function ghazaledb_form_submitted()
{

    if (isset($_POST['submit'])) {
        ghazaledb_insert_into_database();
    }
}

/**
 * handles database update
 */

function ghazaledb_update_database()
{
    global $wpdb;
    global $field_count;

    $table_name = $wpdb->prefix . "ghazaledb";
    $assoc_update = array();

    for ($count = 1; $count <= $field_count; $count++) {

        if (get_option("ghazaledb_type_{$count}") == "Text Area{$count}") {
            $assoc_update["field_{$count}"] = stripcslashes($_POST["ghazaledb_update_textarea_{$count}"]);

        } else {
            $assoc_update['field_' . $count] = stripcslashes($_POST['ghazaledb_update_textfield_' . $count]);
        }

    }

    $update = $wpdb->update($table_name, $assoc_update, array('id' => $_GET['edit']), array('%s'));

    $_SESSION["entry_update"] = "Entry Updated!";
    if (isset($_POST['ghazaledb_edit_submit'])) {

        wp_redirect(get_admin_url() . "admin.php?page=ghazaledb-plugin-menu");
    }
}

add_action( 'wp_loaded', 'ghazaledb_update_and_redirect');

function ghazaledb_update_and_redirect()
{
    if (isset($_POST['ghazaledb_edit_submit'])) {
        ghazaledb_update_database();
    }
}


/**
 * this deletes the selected data on table
 */
function ghazaledb_delete_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";
    $wpdb->delete($table_name, array('id' => $_GET['del']));
    $_SESSION['entry_delete'] = "Entry Deleted!";
    wp_redirect(get_admin_url() . "admin.php?page=ghazaledb-plugin-menu");
}

add_action( 'wp_loaded', 'ghazaledb_entry_delete');

function ghazaledb_entry_delete(){
    if(isset($_GET['del'])){
        ghazaledb_delete_data();
    }
}

/**
 * Bulk Delete
 */


function ghazaledb_bulk_delete(){
    global $wpdb;
    $table_name = $wpdb->prefix . "ghazaledb";

    $bulk_delete = $_POST['deletion_checkbox'];


        if ($_POST['select_bulk_action'] == "Bulk Delete") {

            foreach ($bulk_delete as $id => $delete) {
                $result = $wpdb->delete($table_name, array('id' => $delete));
            }
            if ($result) {
                $_SESSION['entry_delete'] = "Entry Deleted!";
                wp_redirect(get_admin_url() . "admin.php?page=ghazaledb-plugin-menu");
            } else {
                $_SESSION['entry_delete'] = "Please select an item";
                wp_redirect(get_admin_url() . "admin.php?page=ghazaledb-plugin-menu");
            }
        } else {
            $_SESSION['entry_delete'] = "Please select an item";
            wp_redirect(get_admin_url() . "admin.php?page=ghazaledb-plugin-menu");
        }

}

add_action( 'wp_loaded', 'ghazaledb_bulk_deleted');

function ghazaledb_bulk_deleted()
{
    if ($_POST['bulk_action']) {

        ghazaledb_bulk_delete();
    }
}