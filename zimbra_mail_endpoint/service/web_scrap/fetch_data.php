<?php
/* Fetches data from api*/

class Fetch_data{

    private $data;

    function __construct($data){
        $this->data = $data;
    }

    public function auth_check($token){

        $header [] = "Authorization: Basic ".base64_encode($token);
        $user_name = explode(':', $token);
        $url = "https://mail.nitrkl.ac.in/home/".$user_name[0]."?fmt=json";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
            return false;
        } else {
            return true;
        }
        
    }

    public function fetch_inbox($token){

        $header [] = "Authorization: Basic ".base64_encode($token);
        $user_name = explode(':', $token);
        $url = "https://mail.nitrkl.ac.in/home/".$user_name[0]."/inbox?fmt=json";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        return $result;
        
    }

    public function fetch_item($token, $id){

        $header [] = "Authorization: Basic ".base64_encode($token);
        $user_name = explode(':', $token);
        $url = "https://mail.nitrkl.ac.in/home/".$user_name[0]."/inbox?id=".$id."&part=1";
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        return trim(strip_tags($result));
    }
}
?>