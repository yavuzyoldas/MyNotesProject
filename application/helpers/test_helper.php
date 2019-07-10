<?php

function createJSON($data,$message){

    if($data)
        echo json_encode(array(
            "status"    => 200,
            "message"   => $message,
            "data"      => $data

        ));
    else
        echo json_encode(array(
            "status"    => 200,
            "message"   => $message,
        ));

}