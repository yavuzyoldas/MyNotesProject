<?php


class UserBlocked_model extends CI_Model {

    public function getAllUserBlocked() // Kullanıcı id sine srgu yazılıp değiştirilcek. Yanlızca başlıklara göre çekilecek. İçerik için ayrı fonkisyon yazılack.
    {
        $query = $this->db->get('tbl_users_blocked');
        return $query->result_array();
    }

    public function getUserBlocked($userid){

        $this -> db -> where("userid",$userid);

        $result = $this->db-> get("tbl_users_blocked");

          $data= $result ->result_array();

        if(count($data) == 1){
            return true;
        }else
            return false;

    }

    public function insertUserBlocked($data)
    {
        return $this->db->insert("tbl_users_blocked", $data);
    }
    public function updateUserBlocked($data)
    {
        $this->db->where('id',$data['id']);
        return  $this->db->update('tbl_users_blocked',$data );
    }

    public function deleteUserBlocked($data){
        $this  -> db ->where('id',$data['id']);
        return $this -> db -> delete('tbl_users_blocked');
    }

    public function searchUserWithEmail($email){

         $this -> db -> where("email",$email);
         $result = $this -> db -> get("tbl_users");
         $data = $result ->result_array();
         return $data[0]["id"];
    }
    public function searchUserWithEmailBoolean($email){

        $this -> db -> where("email",$email);
        $result = $this -> db -> get("tbl_users");
        $data = $result ->result_array();
        return count($data) > 0 ? true : false;
    }

    public function userBlockedCount($userid){

        $this -> db -> where("userid",$userid);

         $result = $this -> db -> get("tbl_users_blocked");

        $data = $result ->result_array();

        if($data[0]["count"] == 5){

           $data[0]["time"] = time();

           $this->updateUserBlocked($data[0]);
           return $data[0];
        }

        $data[0]["count"] +=1;
        $this->updateUserBlocked($data[0]);
        return true;

    }

    public function getTimeForUserBlocked($email){
        $userid = $this->searchUserWithEmail($email);

        $this -> db -> where("userid",$userid);


         $result =  $this -> db -> get("tbl_users_blocked");

        $data = $result -> result_array();

       return $data[0]["time"];

    }


}