<?php
function json_encode_tr($string)
{
    return json_encode($string, JSON_UNESCAPED_UNICODE);
}
//$array= array(array('turkish' => 'üğışçöÜĞİŞÇÖ'), array('chinese' => '我爱你'), array('arabic' => 'أنا أحبك'));


function generateResponse($statu,$message,$data = null,$token=null){
    if($token)
        print_r(json_encode_tr(array("statu" => $statu, "message" => $message,"token" => $token)));
    else if($data)
        print_r(json_encode_tr(array("statu" => $statu, "message" => $message , "data" => $data)));
    else
        print_r(json_encode_tr(array("statu" => $statu, "message" => $message)));

    exit();
}