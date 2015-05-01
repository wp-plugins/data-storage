<?php
session_start();
function update_message(){
    if(isset($_SESSION["message"])){
        $output = $_SESSION["message"];

        //clear message after use
        $_SESSION["message"]=null;
        return $output;
    }

    if(isset($_SESSION["entry_update"])){
        $output = "<div id = \"message\" class = \"updated\" >";
        $output.= $_SESSION["entry_update"];
        $output .= "<div>";

        //clear message after use
        $_SESSION["entry_update"]=null;
        return $output;
    }

    if(isset($_SESSION['entry_delete'])){
        $output = "<div id = \"message\" class = \"updated\" >";
        $output.= $_SESSION["entry_delete"];
        $output .= "<div>";

        //clear message after use
        $_SESSION["entry_delete"]=null;
        return $output;
    }

}

function redirect_uri(){
    if(isset($_SESSION['redirect_uri'])){
        $output = $_SESSION['redirect_uri'];

        $_SESSION['redirect_uri'] = null;
        return $output;
    }
}