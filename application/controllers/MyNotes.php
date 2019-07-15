<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyNotes extends CI_Controller {


    private $userId = null;

    public function __construct()
    {
        parent::__construct();                  //Kurucu sınıfta  kalıtım alınan CI_Controller ın  kurucusunu çağırdık.
        $this->load->model("MyNotes_model");//Kullanılacak modeli sürekli her yazdığımız fonksiyon içerisinde çağırmamak için kurucuda dahil ettik.

        $token = trim($this->input->post("token"));
        if(!$token){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_NOTE::PERMISSION_DENIED);
        }

        $this->userId = $this->jwt->isLogin($token);
        if(!$this->userId){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_NOTE::PERMISSION_DENIED);
        }

    }

    public function index()
    {
        print_r($this->userId);
        $this->load->library("MyLog");
        $this->mylog->addLog();
    }

    public function get()
    {

         $response = $this->MyNotes_model->getAllNotesForUser($this->userId);
        if($response)
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_NOTE::OK_LIST ,$response);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_NOTE::ERR_UNKNOWN );
    }

    public function insert()
    {
        $data = array(
            "id"      => uniqid(),
            "userid"  => $this->userId,
            "title"   => trim($this->input->post("title")),
            "content" => trim($this->input->post("content"))
        );

        if($data["userid"] == "" || $data["title"] == "" || $data["content"] == "" || $data["id"] == ''){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($this->MyNotes_model->insertNote($data)){
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_NOTE::OK );
        }
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_NOTE::ERR_UNKNOWN );

    }

    public function update(){

        $data = array(

            "content" => trim($this->input->post("content")),
            "title"   => trim($this->input->post("title")),
            "id"      => trim($this->input->post("id"))
        );

        if($data["id"] == "" || $data["title"] == "" || $data["content"] == "" ){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }
        if($this -> MyNotes_model -> updateNote($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_NOTE::OK_UPDATE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_NOTE::ERR_UNKNOWN);
    }

    public function delete(){

        $data["id"] = $this->input->post("id");

        if($data["id"] == ""){
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($this -> MyNotes_model -> deleteNote($data))
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_NOTE::OK_DELETE);
        else
            generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_NOTE::ERR_UNKNOWN);

    }

}
