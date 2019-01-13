<?php
/* Handles when any option is selected in list */

class Option_selected{

    private $data;
    private $fetch_data;
    private $storage;
    private $response;

    function __construct($post){
        $this->data = $post;
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
        $this->response = new Response($this->data);
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
        $this->storage = new Storage($this->data);
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/web_scrap/fetch_data.php");
        $this->fetch_data = new Fetch_data($this->data);
    }

    public function execute(){
        $key = $this->data["originalDetectIntentRequest"]["payload"]["inputs"][0]["arguments"][0]["textValue"];
        if($this->storage->check_for_token()){

            $array = explode(',', $key);
            $item_data = $this->fetch_data->fetch_item($this->storage->send_token(), $array[0]);

            if(isset($item_data)){

                $msg = "Email with id " . $array[0];
                $this->response->card_response($msg, "From: ".$array[1], "To: ". $array[2], $item_data);
            
            } else {
                $this->response->single_response("Connection problem", true);
            }

        } else {
            $this->response->single_response("Connection problem", true);
        }
    }
}
?>