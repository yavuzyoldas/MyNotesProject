<?php

class Users extends CI_Controller{

    public function  __construct()
    {

        parent :: __construct();
        $this->load->model("User_model");//Kullanılacak modeli sürekli her yazdığımız fonksiyon içerisinde çağırmamak için kurucuda dahil ettik.
    }

    public function index()
    {

    }

    public function get()
    {
        $response = $this->User_model->getAllUsers();
        if($response){
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER::OK_LIST,$response);
        }
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER::ERR_UNKNOWN );
    }

    public function insert()
    {
        $data = array(
             "activationcode" =>  md5(uniqid().rand(0,999999)),
             "password"       =>  md5(trim($this->input->post("password"))),
             "surname"        =>  trim($this->input->post("surname")),
             "name"           =>  trim($this->input->post("name")),
             "emaile"         =>  trim($this->input->post("emaile")),
             "type"           =>  trim($this->input->post("type")),
             "id"             =>  uniqid()
        );

        if($data["password"] == '' || $data["surname"] == '' || $data["name"] == '' || $data["emaile"] == '' ||  $data["type"] == '' ||  $data["activationcode"] == '' ){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }
        $response = $this->User_model->insertUser($data);
        if($response){
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER::OK );
        }else{
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER::ERR_UNKNOWN );
        }
    }


    public function update(){

        $data = array(
            "password"       =>  md5(trim($this->input->post("password"))),
            "surname"        =>  trim($this->input->post("surname")),
            "name"           =>  trim($this->input->post("name")),
            "emaile"         =>  trim($this->input->post("emaile")),
            "type"           =>  trim($this->input->post("type")),
            "id"             => trim($this->input->post("id"))
        );

        if($data["id"] == "" || $data["type"] == "" || $data["emaile"] == "" || $data["name"] == "" || $data["surname"] == "" || $data["password"] == ""){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }
        if($this -> User_model -> updateUser($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER::OK_UPDATE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_NOTE::ERR_UNKNOWN);
    }

    public function delete(){

        $data["id"] = $this->input->post("id");

        if($data["id"] == ""){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($this -> User_model -> deleteUser($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER::OK_DELETE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_USER::ERR_UNKNOWN);

    }

//activation link : www.asdasdas.cm/Users/doActivate?k=238hryıewngks7tyubh3qrewfdv




}