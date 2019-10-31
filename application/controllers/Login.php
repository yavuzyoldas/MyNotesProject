<?php
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Login_model");
        $this->load->model("Email_model");
        $this -> load->model("UserBlocked_model");
    }
    public function index()
    {
        $email      = (trim($this->input->post("email")));
        $password   = md5(trim($this->input->post("password")));

        if($email == " " || $password == " "){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_MISSING_PARAMS);
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_EMAIL);
            return;
        }
        // Login Başarılı
        if($this->Login_model->login($email,$password)){
            $this->load->library("jwt");
            $token = $this->jwt->generate_token($this->Login_model->getUserId($email));
            $userid =$this->Login_model->getUserId($email);

           if($this -> UserBlocked_model -> getUserBlocked($userid)){
               if(time() < $this->UserBlocked_model->getTimeForUserBlocked($email)){
                   generateResponse(RESPONSE_CODE::OK,RESP_MSG_USER_BLOCKED::OK_BLOCKED_TIME);
                   return;
               }
           }
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_SIGN::OK_LOGIN,$data = null,$token);
            return;
        }
        else{
            if($userid = $this -> UserBlocked_model -> searchUserWithEmail($email)){
                echo $userid;
                if($this->UserBlocked_model-> getUserBlocked($userid) == true){
                    echo "var";
                      if(is_array( $data = $this->UserBlocked_model -> userBlockedCount($userid))){
                          $data["time"] += 60;
                          $data["count"] = 0;
                          $this -> UserBlocked_model -> updateUserBlocked($data);
                          generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_USER_BLOCKED::OK_BLOCKED);
                      }else{
                          generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_PASSWORD_WRONG);
                      }
                }else{
                    echo "yok";
                    $data = array(
                        "id"      => uniqid(),
                        "userid"  => $userid,
                        "count"   => 1,
                        "time" =>  time()
                    );
                    $this -> UserBlocked_model ->  insertUserBlocked($data);
                }
                generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_PASSWORD_WRONG);
            }else{

                generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_EMAIL);
            }
            generateResponse(RESPONSE_CODE::BAD_REQUEST, RESP_MSG_SIGN::ERR_INVALID_VALUE);
            return;
        }
    }
    public function facebookLogin(){

        $email = (trim($this->input -> post("email")));
        $id = (trim($this->input -> post("id")));
        $name = (trim($this->input -> post("name")));
        $surname = (trim($this->input -> post("surname")));
        $type = (trim($this->input -> post("type")));

        if($this->User_model->isUserInsert($email)){
            $this->load->library("jwt");
            $token = $this->jwt->generate_token($this->Login_model->getUserId($email));
            generateResponse(RESPONSE_CODE::OK,RESP_MSG_SIGN::OK_LOGIN,$data = null,$token);
            return;
        }else{
            $data = array(
                "id" => $id,
                "type" => $type,
                "email" => $email,
                "name" => $name,
                "surname" => $surname,
                "password" => md5($id)
            );
            if($this -> User_model -> insertUser($data)){
                $this->load->library("jwt");
                $token = $this->jwt->generate_token($this->Login_model->getUserId($email));
                generateResponse(RESPONSE_CODE::OK,RESP_MSG_SIGN::OK_LOGIN,$data = null,$token);
                return;
            }else{
                generateResponse(RESPONSE_CODE::BAD_REQUEST,RESP_MSG_SIGN::ERR_UNKNOWN);
                return;
            }
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
            $k =  $this->Login_model->getKValue($email);
            $result = $this->Email_model->sendEmailForForgotEmail($email,$k);
            generateResponse(RESPONSE_CODE::OK, $result == true ? RESP_MSG_FORGOT::SENDED_MAIL : RESP_MSG_FORGOT::ERR_WAIT );
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
        switch($this->Login_model->changeForgottenPassword($k,md5($password1))){
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