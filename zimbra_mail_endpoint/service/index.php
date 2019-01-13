<?php
/* Main handling section */

//error_reporting(0);
//ini_set('display_errors', 0);

$post = json_decode(file_get_contents('php://input'), true);
require_once("post_check.php");

$check = new Post_check($post);

if($check->validate()){

    $check->intent_handler();

} else {

    echo "Authorization problem";

}

?>