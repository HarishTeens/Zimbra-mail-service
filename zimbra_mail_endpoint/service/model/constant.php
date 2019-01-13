<?php

/* defines constant for functional working */

class Constant{
 
    public static function welcome_intent(){
       return  "Default Welcome Intent";
    }

    public static function fetch_email_intent(){
        return "fetch email";
    }

    public static function list_option_selection_intent(){
        return "list option selected";
    }

    public static function confirm_intent(){
        return "confirm";
    }

    public static function fallback_intent(){
        return "Default Fallback Intent";
    }

    public static function logout(){
        return "logout";
    }
}

?>