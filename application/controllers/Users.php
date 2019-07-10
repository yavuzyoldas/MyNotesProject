<?php

class Users extends CI_Controller{

    public function  __construct()
    {

        parent :: __construct();
        $this->load->model("User_model");//Kullanılacak modeli sürekli her yazdığımız fonksiyon içerisinde çağırmamak için kurucuda dahil ettik.
        $this->load->model("Email_model");
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

    public function insertTemp()
    {
        $data = array(
             "activationcode" =>  md5(uniqid().rand(0,999999)),
             "password"       =>  trim($this->input->post("password")),
             "surname"        =>  trim($this->input->post("surname")),
             "name"           =>  trim($this->input->post("name")),
             "email"          =>  trim($this->input->post("email")),
             "type"           =>  trim($this->input->post("type")),
             "id"             =>  uniqid()
        );

        if($data["password"] == '' || $data["surname"] == '' || $data["name"] == '' || $data["email"] == '' ||  $data["type"] == '' ||  $data["activationcode"] == '' ){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_EMAIL);
            return;
        }
        if(strlen($data["password"]) < 6){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_PASSWORD_SHORT);
            return;
        }

        $data["password"] =md5($data["password"]);


        if($this->Email_model->isValidEmail($data["email"]) == false){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_USING_EMAIL);
            return;
        }


        $response = $this->User_model->insertUserTemp($data);
        if($response && $this -> Email_model -> sendToActivationEmail($data["activationcode"],$data["email"])){
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_SIGN::OK_TEMP);
        }else{
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER::ERR_UNKNOWN );
        }

    }

    public function insert(){

        $code = $this->input->get("k");

         $this->db->where("activationcode",$code);
         $query = $this->db->get("tbl_users_temp");
         $user = $query->result_array();
         if( $user != null){


             $data = array(
                 "password"       =>  $user[0]["password"],
                 "surname"        =>  $user[0]["surname"],
                 "name"           =>  $user[0]["name"],
                 "email"          =>  $user[0]["email"],
                 "type"           =>  $user[0]["type"],
                 "id"             =>  $user[0]["id"]
             );
             if($data["id"] == "" || $data["type"] == "" || $data["email"] == "" || $data["name"] == "" || $data["surname"] == "" || $data["password"] == ""){
                 generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
                 return;
             }

             if($this -> User_model -> insertUser($data)){
                 $this->User_model  -> deleteUserTemp($data);
                 generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER::OK);
                 return;
             }else
                 generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_USER::ERR_UNKNOWN);
         }else{
                 generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_LINK);
         }


    }




    public function update(){

        $data = array(
            "password"       =>  md5(trim($this->input->post("password"))),
            "surname"        =>  trim($this->input->post("surname")),
            "name"           =>  trim($this->input->post("name")),
            "email"         =>  trim($this->input->post("email")),
            "type"           =>  trim($this->input->post("type")),
            "id"             => trim($this->input->post("id"))
        );

        if($data["id"] == "" || $data["type"] == "" || $data["email"] == "" || $data["name"] == "" || $data["surname"] == "" || $data["password"] == ""){
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