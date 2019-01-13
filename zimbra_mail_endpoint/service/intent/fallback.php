<?php
/*Fallback intent */

class Fallback{

    private $data;
    private $response;
    private $storage;
    private $fetch_data;

    function __construct($data){
        $this->data = $data;
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
        $this->response = new Response($this->data);
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
        $this->storage = new Storage($this->data);
        require("/home/matrixfr/public_html/zimbra_mail_endpoint/service/web_scrap/fetch_data.php");
        $this->fetch_data = new Fetch_data($this->data);
    
    }

    public function execute(){
        $query = $this->data["queryResult"]["queryText"];
    
        if(strpos($query, ':') !== false){
            $auth = trim($query);
            $array = explode(':', $auth);

            if($array[0] != 'From'){

            if($this->fetch_data->auth_check($auth)){
                $this->response->login_success_response($auth);
            } else {
                $this->response->error_response();
            }
        } else {
            
            if($this->storage->check_for_token()){

                $user = $this->storage->send_token();
                $user_name = explode(':', $user);
                $item_data = $this->fetch_data->fetch_item($user, $array[2]);

            if(isset($item_data)){

                $msg = "Email with id " . $array[2];
                $this->response->card_response($msg, "From: ".$array[1]. ": ". $array[2], "To: ". $user_name[0]. "@nitrkl.ac.in", $item_data);
            
            } else {
                $this->response->single_response("Connection problem", true);
            }

            } else {
                $this->response->error_response();
            }

        }

        } else {
            $text = $this->data["queryResult"]["fulfillmentText"];
            $this->response->single_response($text, true);
        }
    }
}
?>