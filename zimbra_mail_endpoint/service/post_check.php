<?php

/* 
handle input content
*/

class Post_check{

    public $post_data;
    public $constant;

    function __construct($post_data){
        $this->post_data = $post_data;
        require("model/constant.php");
        $this->constant = new Constant;
    }

    public function validate(){
        if($this->post_data){
            return true;
        } else {
            return false;
        }
    }

    public function intent_handler(){
        switch($this->post_data['queryResult']['intent']['displayName']){

            case $this->constant->welcome_intent() :

                    require('intent/welcome.php');
                    $intent = new Welcome($this->post_data);
                    $intent->execute();

                       break;

            case $this->constant->fetch_email_intent() :

                    require('intent/fetch_email.php');
                    $intent = new Fetch_email($this->post_data);
                    $intent->execute();

                       break;

            case $this->constant->confirm_intent() :

                    require('intent/confirm.php');
                    $intent = new Confirm($this->post_data);
                    $intent->execute();

                       break;

            case $this->constant->list_option_selection_intent() :

                    require('intent/option_selected.php');
                    $intent = new Option_selected($this->post_data);
                    $intent->execute();

                       break;

            case $this->constant->fallback_intent() :

                    require('intent/fallback.php');
                    $intent = new Fallback($this->post_data);
                    $intent->execute();

                       break;

            case $this->constant->logout() :

                    require('intent/logout.php');
                    $intent = new Logout($this->post_data);
                    $intent->execute();

                       break;

            default :

                    require('intent/default.php');
                    $intent = new Default_intent($this->post_data);
                    $intent->execute();

                       break; 
        }
    }

}
?>