<?php
session_start();
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
        $output = $_SESSION["ds-update"];

        //clear message after use
        $_SESSION["ds-update"]=null;
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