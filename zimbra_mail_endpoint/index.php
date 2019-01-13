<?php
//error_reporting(0);
//ini_set('display_errors', 0);
$header [] = "Authorization: Basic ".base64_encode("117ee0371:Abhishek@123");
$url = "https://mail.nitrkl.ac.in/home/117ee0371/inbox?fmt=json";



$post = json_decode(file_get_contents('php://input'), true);
if($post){
    //echo "post";
} else {
    die("unable to connect");
    //echo "authorization required";
    //
}


if($post['queryResult']['intent']['displayName'] == "fetch email"){
    
    $user_date = $post["queryResult"]["parameters"]["date"];
    $auth_token = $post["queryResult"]["outputContexts"][1]["parameters"]["data"];
    $system_day = substr($user_date, 8, 2);
    
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_FAILONERROR, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($curl);

if (curl_error($curl)) {
    $error_msg = curl_error($curl);
    $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Invalid credential")))))));

                echo json_encode($msg);
} else {
    
    
    $result_dec =  rtrim($result,"1 ");
    $json_array = json_decode($result_dec,true);
    $count = 0;
    $message; $ass_name; $ass_msg;

foreach($json_array as $key => $arrays){
    foreach($arrays as $array){
        $msg_day = date('d', (int) substr($array['d'],0,-3));
        
        if($system_day == $msg_day){
            $ass_name[$count] = $array['e'][1]['d'];
            $ass_msg[$count] = $array['fr'];
            $count += 1;
            //echo $array['su']."<br />";
        } else {
            //$message = "Your today's inbox is empty";
                break;
        }
        
    }
}

if($count == 0){
    $message = "Your today's inbox is empty ".$system_day;
} else {
    $message = "You have got " . $count . " messages today.";
   $count_int = 0;
   while($count_int <= $count){
       $message = $message . "From " . $ass_name[$count_int] . ", Message " . $ass_msg[$count_int] . ".";
       $count_int += 1;
   }
             
}

$reply = array("payload" => array("google" => 
                array("expectUserResponse" => true, "userStorage"=>"{\"data\":{}}" , "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => $message)))))));


$list = array("payload"=>array("google"=>array("expectUserResponse"=> true, "richResponse"=>array("items"=>array(array("simpleResponse"=>array("textToSpeech"=>"Choose a item")))),
                "systemIntent"=>array("intent"=>"actions.intent.OPTION", "data"=>array("@type"=> "type.googleapis.com/google.actions.v2.OptionValueSpec", "listSelect"=>
                  array("title"=>"Hello", "items"=>array(array("optionInfo"=>array("key"=> "first title key"), "description"=> "first description", "title"=>"first title"),
                   array("optionInfo"=>array("key"=> "second"), "description"=> "second description", "title"=>"second title"))))))));

$dec = json_decode($auth_token, true);
    
    if(isset($dec['token'])){
                echo json_encode($reply);
} else {
    echo json_encode($list);
}
}

curl_close($curl);
}

if($post['queryResult']['intent']['displayName'] == "Default Welcome Intent"){
    
    $cred = $post["originalDetectIntentRequest"]["payload"]["user"]["userStorage"];
    $auth_token = $post["queryResult"]["outputContexts"][1]["parameters"]["data"];
    $dec = json_decode($cred,true);
    
    if(!isset($dec['data']['email'])){
        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "userStorage"=>"{\"data\":{\"email\":\"abhi\"}}", "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Zimbra mail server connected", "displayText"=>"Login cred is null")), array("simpleResponse"=>array("textToSpeech"=>"Zimbra again again")))))));


                //echo json_encode($msg);
    } else {
        $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Zimbra mail server connected", "displayText"=>"Login cred is not null")), array("simpleResponse"=>array("textToSpeech"=>"Zimbra again again")))))));


                //echo json_encode($msg);
    }
    
    $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "userStorage"=>"{\"data\":{\"email\":\"117ee0371\", \"password\":\"abhishek\"}}", "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Zimbra mail server connected", "displayText"=>"Zimbra again")), array("simpleResponse"=>array("textToSpeech"=>"Zimbra again again")))))));


                //echo json_encode($msg);
                
                $token = array("payload" => array("google" => 
                array("expectUserResponse" => true, "userStorage"=>"{\"data\":{\"email\":\"abhi\"}}", "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => "Zimbra mail server connected", "displayText"=>"Login cred is null")), array("simpleResponse"=>array("textToSpeech"=>"Zimbra again again"))))))
                  , "outputContexts"=>array(array("name"=> $post['session']."/contexts/_actions_on_google", "lifespanCount"=> 99, "parameters"=>array("data"=>"{\"token\":\"abhi\"}"))));
                  
                  
                echo json_encode($token);
                
                
}
    
  
  
if($post['queryResult']['intent']['displayName'] == "list option selected"){
    $key = $post["originalDetectIntentRequest"]["payload"]["inputs"][0]["arguments"][0]["textValue"];
    
    $confirm_sel = array("payload"=>array("google"=>array("expectUserResponse"=>true, "systemIntent"=>array("intent"=>"actions.intent.CONFIRMATION",
                   "data"=>array("@type"=>"type.googleapis.com/google.actions.v2.ConfirmationValueSpec", "dialogSpec"=>array("requestConfirmationText"=>$key." okay ???"))), "richResponse"=>array(
                       "items"=>array(array("simpleResponse"=>array("textToSpeech"=>"hello")))))));
    
    $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => $key)))))));
                
    $card = array("payload"=>array("google"=>array("expectUserResponse"=> true, "richResponse"=>array("items"=>array(array(
               "simpleResponse"=>array("textToSpeech"=> "This is a Basic Card :)")), array("basicCard"=>array("title"=>"card title",
                 "subtitle"=>"this is subtitle", "formattedText"=>"This is formatted text ")))))));

                echo json_encode($card);
}


if($post['queryResult']['intent']['displayName'] == "confirm"){
    $value = $post['originalDetectIntentRequest']['payload']['inputs'][0]['arguments'][0]['boolValue'];
    $msg = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => $value)))))));


                echo json_encode($msg);
}

if($post['queryResult']['intent']['displayName'] == "Default Fallback Intent"){
    $a = $post["queryResult"]["queryText"];
    if (strpos($a, ':') !== false) {
    
    $reply = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => $a)))))));
    echo json_encode($reply);

} else {
    $text = $post["queryResult"]["fulfillmentText"];
    $reply = array("payload" => array("google" => 
                array("expectUserResponse" => true, "richResponse" => array("items" => 
                array(array("simpleResponse" => 
                array("textToSpeech" => $text)))))));

echo json_encode($reply);
}
}
    
  
?>
