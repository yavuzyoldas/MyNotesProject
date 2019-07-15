<?php


class UserBlocked extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("UserBlocked_model");
    }

    public function index()
    {

    }
    public function get()
    {

        $response = $this->UserBlocked_model->getAllUserBlocked();
        if($response)
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK_LIST ,$response);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER_BLOCKED::ERR_UNKNOWN );
    }

    public function getByUserId(){

        $response = $this->UserBlocked_model->getUserBlocked();
        if($response)
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK_LIST ,$response);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER_BLOCKED::ERR_UNKNOWN );


    }

    public function insert()
    {
        $data = array(
            "id"      => uniqid(),
            "userid"  => trim($this->input->post("userid")),
            "count"   => trim($this->input->post("count")),
            "time" => trim($this->input->post("time"))
        );

        if($data["userid"] == "" || $data["count"] == "" || $data["time"] == "" || $data["id"] == ''){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($this->UserBlocked_model->insertUserBlocked($data)){
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK );
        }
        generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER_BLOCKED::ERR_UNKNOWN );

    }



    public function update(){

        $data = array(
            "time" => trim($this->input->post("time")),
            "count" => trim($this->input->post("count")),
            "userid"   => trim($this->input->post("userid")),
            "id"      => trim($this->input->post("id"))
        );

        print_r($data);
        if($data["id"] == "" || $data["userid"] == "" || $data["count"] == "" || $data["time"] == "" ){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }
        if($this -> UserBlocked_model -> updateUserBlocked($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK_UPDATE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_USER_BLOCKED::ERR_UNKNOWN);
    }

    public function delete(){

        $data["id"] = $this->input->post("id");

        if($data["id"] == ""){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($this -> UserBlocked_model -> deleteUserBlocked($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK_DELETE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_USER_BLOCKED::ERR_UNKNOWN);

    }



}