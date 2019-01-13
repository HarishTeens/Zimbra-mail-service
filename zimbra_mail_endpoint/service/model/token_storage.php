<?php
/* stores token and storage */

class Storage{

    private $data;

    function __construct($data){
         $this->data = $data;
    }

    public function check_for_storage(){
        $cred = $this->data["originalDetectIntentRequest"]["payload"]["user"]["userStorage"];
        $dec = json_decode($cred,true);
    
        if(isset($dec['data']['perm_token'])){
              return true;
        } else {
              return false;
        }
    }

    public function check_for_token(){
        $auth_context = $this->data["queryResult"]["outputContexts"];
        foreach($auth_context as $context){

              if(isset($context['parameters']['data'])){
                  $dec = json_decode($context['parameters']['data'], true);

                  if(isset($dec['tem_token'])){
                        return true;
                  } else {
                        return false;
                  }

              } else {
                    //return false;
              }

        }
    }

    public function send_token(){
      $auth_context = $this->data["queryResult"]["outputContexts"];
        foreach($auth_context as $context){

              if(isset($context['parameters']['data'])){
                  $dec = json_decode($context['parameters']['data'], true);
                  return $dec['tem_token'];

              } else {
                    
              }
        }

    }

    public function send_storage(){
      $cred = $this->data["originalDetectIntentRequest"]["payload"]["user"]["userStorage"];
      $dec = json_decode($cred,true);
  
      return $dec['data']['perm_token'];
      
    }

}
?>