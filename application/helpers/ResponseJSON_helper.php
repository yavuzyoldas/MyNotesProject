<?php
function generateResponse($statu,$message,$data = null,$token=null){
    if($token)
        print_r(json_encode(array("statu" => $statu, "message" => $message,"token" => $token)));
    else if($data)
        print_r(json_encode(array("statu" => $statu, "message" => $message , "data" => $data)));
    else
        print_r(json_encode(array("statu" => $statu, "message" => $message)));

    exit();
}