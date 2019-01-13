<?php
/*handles response sended by intent */

class Response{

    private $data;

    function __construct($data){
        $this->data = $data;
    }

    public function simple_start_response(){

        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "welcome to zimbra mail service", "displayText"=>"Please enter your zimbra mail username and password in the given format")), 
                array("simpleResponse"=>array("textToSpeech"=>"username:password")))))));

                echo json_encode($msg);

    }

    public function single_response($text, $end){

        $reply = array("payload" => array("google" => 
                  array("expectUserResponse" => $end, "richResponse" => array("items" => 
                  array(array("simpleResponse" => 
                  array("textToSpeech" => $text)))))));

                  echo json_encode($reply);
    }

    public function error_response(){

        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Invalid credential..Enter username password in given format")), 
                array("simpleResponse"=>array("textToSpeech" => "username:password")))))));

                echo json_encode($msg);

    }

    public function login_success_response($auth){

        $confirm = array("payload"=>array("google"=>array("expectUserResponse"=>true, "systemIntent"=>array("intent"=>"actions.intent.CONFIRMATION",
                   "data"=>array("@type"=>"type.googleapis.com/google.actions.v2.ConfirmationValueSpec", "dialogSpec"=>array
                   ("requestConfirmationText"=>"Do you want to save your password"))), "richResponse"=>array(
                       "items"=>array(array("simpleResponse"=>array("textToSpeech"=>"You will be having full control on your data, it will be stored in your google account.")))))), "outputContexts"=>array
                       (array("name"=> $this->data['session']."/contexts/_actions_on_google", "lifespanCount"=> 99, "parameters"=>array("data"=>"{\"tem_token\":\"".$auth."\"}")),
                    array("name"=> $this->data['session']."/contexts/actions_capability_screen_output", "lifespanCount"=> 99, "parameters"=>array("data"=>"{\"tem_token\":\"".$auth."\"}")), 
                    array("name"=> $this->data['session']."/contexts/actions_capability_audio_output", "lifespanCount"=> 99, "parameters"=>array("data"=>"{\"tem_token\":\"".$auth."\"}")), 
                    array("name"=> $this->data['session']."/contexts/google_assistant_input_type_keyboard", "lifespanCount"=> 99, "parameters"=>array("data"=>"{\"tem_token\":\"".$auth."\"}"))));

                echo json_encode($confirm);

    }

    public function confirmed($token){

        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "userStorage"=>"{\"data\":{\"perm_token\":\"".$token."\"}}", "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Credential successfully saved")), array("simpleResponse"=>array("textToSpeech"=>"How can we help you ??")))))));

                echo json_encode($msg);

    }

    public function not_confirmed(){

        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "okay")), array("simpleResponse"=>array("textToSpeech"=>"How can we help you ??")))))));

                echo json_encode($msg);

    }

    public function returning_user($token){

        $msg =  array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "welcome again")), array("simpleResponse"=>array("textToSpeech"=>"How can we help you ??"))))))
                     , "outputContexts"=>array(array("name"=> $this->data['session']."/contexts/_actions_on_google", "lifespanCount"=> 99,
                       "parameters"=>array("data"=>"{\"tem_token\":\"".$token."\"}")), array("name"=> $this->data['session']."/contexts/actions_capability_screen_output", "lifespanCount"=> 99,
                       "parameters"=>array("data"=>"{\"tem_token\":\"".$token."\"}")), array("name"=> $this->data['session']."/contexts/actions_capability_audio_output", "lifespanCount"=> 99,
                       "parameters"=>array("data"=>"{\"tem_token\":\"".$token."\"}")), array("name"=> $this->data['session']."/contexts/google_assistant_input_type_keyboard", "lifespanCount"=> 99,
                       "parameters"=>array("data"=>"{\"tem_token\":\"".$token."\"}"))));
                  
                  echo json_encode($msg);

    }

    public function logout(){

        $reply = array("payload" => array("google" => 
                  array("expectUserResponse" => false, "userStorage"=>"{\"data\":{}}", "richResponse" => array("items" => 
                  array(array("simpleResponse" => 
                  array("textToSpeech" => "Logged out")))))));

                echo json_encode($reply);
    }

    public function list_response($msg, $meta){

        $list = array("payload"=>array("google"=>array("expectUserResponse"=> true, "richResponse"=>array("items"=>
                array(array("simpleResponse"=>array("textToSpeech"=>"" . $msg . "")))),
                "systemIntent"=>array("intent"=>"actions.intent.OPTION", "data"=>array("@type"=> "type.googleapis.com/google.actions.v2.OptionValueSpec",
                 "listSelect"=>array("title"=>"Your emails", "items"=>$meta))))));

                echo json_encode($list);

    }
    
    public function card_response($msg, $title, $subtitle, $content){
        
         $card = array("payload"=>array("google"=>array("expectUserResponse"=> true, "richResponse"=>array("items"=>array(array(
               "simpleResponse"=>array("textToSpeech"=> $msg)), array("basicCard"=>array("title"=>$title,
                 "subtitle"=>$subtitle, "formattedText"=>$content)))))));

                echo json_encode($card);
                
    }

}
?>