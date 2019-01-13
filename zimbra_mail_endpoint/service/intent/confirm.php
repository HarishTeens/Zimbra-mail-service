<?php
/* Handles when save password command execute */

class Confirm{

    private $data;
    private $response;
    private $storage;

    function __construct($post){
        $this->data = $post;
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
        $this->response = new Response($this->data);
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
        $this->storage = new Storage($this->data);
    }

    public function execute(){
        $value = $this->data['originalDetectIntentRequest']['payload']['inputs'][0]['arguments'][0]['boolValue'];

        if($value){
            $this->response->confirmed($this->storage->send_token());
        } else {
            $this->response->not_confirmed();
        }
    }
}
?>