<?php
if(!session_id()) {
    session_start();
}
/**
 * message session
 */
function ghazale_ds_message(){
    if(isset($_SESSION["ds-message"])){
        $output = "<div id = \"message\" class = \"updated\" >";
        $output .= $_SESSION["ds-message"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["ds-message"]=null;
        return $output;
    }

}


function ghazale_ds_update(){
    if(isset($_SESSION["ds-update"])){
        $output = "<div style='background-color: #b6c669; color: #fff;border-left: 5px solid #47a447; padding-left: 10px'>";
        $output .= $_SESSION["ds-update"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["ds-update"]=null;
        return $output;
    }
    if(isset($_SESSION["ds-error"])){
        $output = "<div style='background-color: #e14d43; color: #fff;border-left: 5px solid #ff0000; padding-left: 10px'>";
        $output .= $_SESSION["ds-error"];
        $output .= "</div>";

        //clear message after use
        $_SESSION["ds-error"]=null;
        return $output;
    }
}

function ghazale_ds_captcha(){
    if(isset($_SESSION["ds-captcha"])){
        $output = $_SESSION["ds-captcha"];

        //clear message after use
        $_SESSION["ds-captcha"]=null;
        return $output;
    }
}