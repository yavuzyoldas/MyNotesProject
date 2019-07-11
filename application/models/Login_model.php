<?php
class Login_model extends CI_Model
{

    public function login($email,$password){
        /*$this->db->where("email",$email);
        $this->db->where("password",$password);

        return $this->db->get('tbl_admins')->num_rows() == 1 ? true : false;*/
        $this -> db ->where("email",$email);
        $this -> db ->where("password",$password);
        return $this -> db ->get("tbl_users") -> num_rows() == 1 ? true : false;

    }

    public function getUserId($email){
        /*$this->db->where("email",$email);
        $result = $this->db->get('tbl_admins');
        if($result->num_rows() == 1)
            return $result->first_row()->id;
        else
            return false;*/

        $this -> db -> where("email",$email);
        $result = $this -> db -> get("tbl_users");
        if($result->num_rows()){
            return $result->first_row()->id;
        }else{
            return false;
        }
    }
    public function forgotPassword($email){

        $this->db->where("email",$email);

        if($this-> db -> get("tbl_users")->num_rows() == 1){
            $this->db->where("email",$email);
            $result = $this->db->get("tbl_forgotten_password");
            if($result->num_rows() > 0 )
                if($result->last_row()->date + FORGOT_REMAIL_TIME > time() )
                    return 2;
                   $k = md5(time()."_+".$email);
            $data = array(
                "email" => $email,
                "k"     => $k
            );



            return $this->db->insert("tbl_forgotten_password",$data) ? 1 : -1;
        }else{
            return -1;
        }
    }

    public function changeForgottenPassword($k,$password){
        $this->db->where("k",$k);

        $result = $this->db->get("tbl_forgotten_password");
        if($result->num_rows() != 1){
            return -1;
        }
        //password güncellenir
        $result = $result->last_row();
        $this->db->where("email",$result->email);
        $this->db->set("password",$password);
        $result = $this->db->update("tbl_user");

        //forgotten tablosundaki kayıt temizlenir
        $this->db->where("k",$k);
        $this->db->delete("tbl_forgotten_password");
        return $result ? 1 : 0;
    }

    public function getKValue($email){

        $this ->db ->where("email",$email);

        $result = $this-> db -> get("tbl_forgotten_password");

        $data =  $result->result_array();


        print_r($data);
        echo   $data[0]["k"];
        return $data[0]["k"];
    }



}