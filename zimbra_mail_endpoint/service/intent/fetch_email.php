<?php
/* Handles when email is fetched */

class Fetch_email{

    private $data;
    private $fetch_data;
    private $storage;
    private $response;

    function __construct($post){
        $this->data = $post;
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/web_scrap/fetch_data.php");
        $this->fetch_data = new Fetch_data($this->data);
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
        $this->storage = new Storage($this->data);
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
        $this->response = new Response($this->data);
    }

    public function execute(){

        if($this->storage->check_for_token()){

            $token = $this->storage->send_token();
            $result = $this->fetch_data->fetch_inbox($token);
            $result_dec =  rtrim($result,"1 ");
            $json_array = json_decode($result_dec, true);
            
            if(isset($result) && !empty($result) && isset($json_array)){

                $user_date = $this->data["queryResult"]["parameters"]["date"];
                
                   if(!empty($user_date) && isset($user_date)){

                    $user_day = substr($user_date, 8, 2);
                    $this->process_email($json_array, $user_day);
                   } else {

                    $sys_date = date("d", time());
                    $this->process_email($json_array, $sys_date);
                   }
                  
            } else {

                $this->response->single_response("Connection problem", true);
            }

        } else {

            $this->response->error_response();
        }
    }

    private function process_email($result, $date){

        $count = 0;
        $id; $msg; $sender; $sender_name; $receiver; $msg_date; $message; $final_array = array();

        foreach($result as $key => $arrays){
            foreach($arrays as $array){

                $msg_day = date('d', (int) substr($array['d'],0,-3));
                
                if($date == $msg_day){

                    $sender_name[$count] = $array['e'][1]['d'];
                    $msg[$count] = $array['fr'];
                    $id[$count] = $array['id'];
                    $sender[$count] = $array['e'][1]['a'];
                    $receiver[$count] = $array['e'][0]['a'];
                    $msg_date[$count] = $array['d'];

                    $count += 1;
                    
                } else {
                    if($count != 0){
                        break;
                    }
                }
                
            }
        }
        
        if($count != 0){

          $new_counter = 1;
            while($new_counter <= $count){
                
                if($count == 1){
                    
                    $item_data = $this->fetch_data->fetch_item($this->storage->send_token(), $id[$new_counter-1]);
                    if(isset($item_data)){
                        
                        $sys_day = date('d', time());
                        $yes_day = $sys_day - 01;

            switch($date){
                case $sys_day :
                    $msg = "You have got " . $count . " email " . "today";
                    $this->response->card_response($msg, "From: ".$sender[$new_counter-1]. " (". $sender_name[$new_counter-1]. ")", "To: ". $receiver[$new_counter-1], $item_data);
                break;

                case $yes_day :
                    $msg = "You have got " . $count . " email " . "yesterday";
                    $this->response->card_response($msg, "From: ".$sender[$new_counter-1]. " (". $sender_name[$new_counter-1]. ")", "To: ". $receiver[$new_counter-1], $item_data);
                break;

                default :
                    $msg = "You have got " . $count . " email " . "that day";
                    $this->response->card_response($msg, "From: ".$sender[$new_counter-1]. " (". $sender_name[$new_counter-1]. ")", "To: ". $receiver[$new_counter-1], $item_data);
                break;
              }
                        
                    } else {
                        $this->response->single_response("Connection problem", true);
                    }
                    
                } else {
                    
                    $message = array("optionInfo"=>array("key"=> $id[$new_counter-1] . "," . $sender[$new_counter-1] .
                     "," . $receiver[$new_counter-1] ), "description"=> $msg[$new_counter-1] , "title"=> "From: " . 
                     $sender[$new_counter-1] . " (". $sender_name[$new_counter-1] . ") id:" . $id[$new_counter-1]);

                     array_push($final_array, $message);
                     
                }

                $new_counter += 1;
            }

            if($count != 1){
            $sys_day = date('d', time());
            $yes_day = $sys_day - 01;

            switch($date){
                case $sys_day :
                    $msg = "You have got " . $count . " email " . "today";
                    $this->response->list_response($msg, $final_array);
                break;

                case $yes_day :
                    $msg = "You have got " . $count . " email " . "yesterday";
                    $this->response->list_response($msg, $final_array);
                break;

                default :
                    $msg = "You have got " . $count . " email " . "that day";
                    $this->response->list_response($msg, $final_array);
                break;
              }
            }

        } else {

            $sys_day = date('d', time());
            $yes_day = $sys_day - 01;

            switch($date){
                case $sys_day :
                    $msg = "You have not got any email today";
                    $this->response->single_response($msg, true);
                    
                break;

                case $yes_day :
                    $msg = "You did not have any emails yesterday";
                    $this->response->single_response($msg, true);
                break;

                default :
                    $msg = "You did not have any emails that day";
                    $this->response->single_response($msg, true);
                break;
            }
        }
    }
    
}
?>