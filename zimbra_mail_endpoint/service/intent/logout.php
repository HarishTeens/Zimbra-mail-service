<?php
/* Handle logout event */

class Logout{

    private $data;
    private $response;
    private $storage;

    function __construct($post){
        $this->data = $post;
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
        $this->storage = new Storage($this->data);
        include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
        $this->response = new Response($this->data);
    }

    public function execute(){
        if($this->storage->check_for_token()){
            $this->response->logout();
        } else {
            $this->response->logout();
        }
    }
}
?>