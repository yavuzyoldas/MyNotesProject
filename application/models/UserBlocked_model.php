<?php


class UserBlocked_model extends CI_Model {

    public function getAllUserBlocked() // Kullanıcı id sine srgu yazılıp değiştirilcek. Yanlızca başlıklara göre çekilecek. İçerik için ayrı fonkisyon yazılack.
    {
        $query = $this->db->get('tbl_users_blocked');
        return $query->result_array();
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
}