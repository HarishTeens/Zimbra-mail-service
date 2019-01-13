<?php
/* Handles welcome intent */
include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/token_storage.php");
include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/model/response.php");
include("/home/matrixfr/public_html/zimbra_mail_endpoint/service/web_scrap/fetch_data.php");

class Welcome{

    private $data;
    private $storage;
    private $response;
    private $fetch_data;

    function __construct($post){
        $this->data = $post;
        $this->storage = new Storage($this->data);
        $this->response = new Response($this->data);
        $this->fetch_data = new Fetch_data($this->data);
    }

    public function execute(){
        if($this->storage->check_for_storage()){
            $cred = $this->data["originalDetectIntentRequest"]["payload"]["user"]["userStorage"];
            $dec = json_decode($cred, true);
              
            if($this->fetch_data->auth_check($dec['data']['perm_token'])){
                $this->response->returning_user($dec['data']['perm_token']);
            } else {
                $this->response->error_response();
            }

        } else {
            $this->response->simple_start_response();
        }
    }
}
?>