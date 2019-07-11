<?php
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Login_model");
        $this->load->model("Email_model");
       // $this->load->library("JWT");
    }
    public function index()
    {
        $email      = (trim($this->input->post("email")));
        $password   = md5(trim($this->input->post("password")));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_EMAIL);
            return;
        }
        // Login Başarılı
        if($this->login_model->login($email,$password)){
            $this->load->library("jwt");
            $token = $this->jwt->generate_token($this->login_model->getUserId($email));
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_SIGN::OK_LOGIN,$data = null,$token);
            return;
        }
        else{
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_VALUE);
            return;
        }
    }
    public function forgotPassword()
    {
        $email = (trim($this->input->post("email")));

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_EMAIL);
            return;
        }
       $response = $this->Login_model->forgotPassword($email);
        if($response > 0){

            $this->Login_model->getKValue($email);
            exit;
            $result = $this->Email_model->sendEmailForForgotEmail($email,$k);
            generateResponse(RESPONSE_CODE::BAD_REQUEST, $result == true ? RESP_MSG_FORGOT::SENDED_MAIL : RESP_MSG_FORGOT::ERR_WAIT );
            return;
        }
        else{
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_FORGOT::ERR_INVALID_EMAIL);
            return;
        }
    }

    public function changeForgottenPassword(){
        $k = trim($this->input->post("k"));
        $password1 = (trim($this->input->post("password1")));
        $password2 = (trim($this->input->post("password2")));

        if( $k == "" ||
            $password1 == "" ||
            $password2 == ""
        ){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }

        if($password1 != $password2){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_PASSWORD_MATCH);
            return;
        }
        switch($this->login_model->changeForgottenPassword($k,md5($password1))){
            case -1:
                generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_FORGOT::ERR_PARAMETER);
                return;
            case 0:
                generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_FORGOT::ERR_UNKNOWN);
                return;
            case 1:
                generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_FORGOT::OK);
                return;

        }
    }
}