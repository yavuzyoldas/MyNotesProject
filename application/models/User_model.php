<?php


class User_model extends CI_Model
{

    public function getAllUsers()
    {
        $query = $this->db->get('tbl_users');
        return $query->result_array();
    }

    public function getUser($data){
        $this->db->where("id",$data["id"]);
        return $this ->db->get("tbl_users");
    }
    public function isUserInsert($email){

        $this->db->where("email",$email);
        $this->db->where("type",2);
        $this ->db -> select("id,type,email");
        $result = $this ->db->get("tbl_users");
        if($result ->num_rows() > 0)
            return true;
        else
            return false;

    }


    public function insertUserTemp($data)
    {
        return $this->db->insert("tbl_users_temp", $data);
    }

    public function  insertUser($data){

        return $this->db->insert("tbl_users", $data);
    }

    public function updateUser($data)
    {
        $this -> db -> where('id',$data['id']);
        return $this->db->update('tbl_users',$data );
    }

    public function deleteUser($data){

        $this  -> db -> where('id',$data['id']);
        return $this -> db -> delete('tbl_users');

    }
    public function deleteUserTemp($data){

        $this  -> db -> where('id',$data['id']);
        return $this -> db -> delete('tbl_users_temp');

    }





}