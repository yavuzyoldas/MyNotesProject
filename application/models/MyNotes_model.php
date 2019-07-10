<?php
class MyNotes_model extends CI_Model {

    public function getAllNotes() // Kullanıcı id sine srgu yazılıp değiştirilcek. Yanlızca başlıklara göre çekilecek. İçerik için ayrı fonkisyon yazılack.
    {
        $query = $this->db->get('tbl_notes');
        return $query->result_array();
    }
    public function insertNote($data)
    {
        return $this->db->insert("tbl_notes", $data);
    }
    public function updateNote($data)
    {
         $this->db->where('id',$data['id']);
         return  $this->db->update('tbl_notes',$data );
    }

    public function deleteNote($data){
        $this  -> db ->where('id',$data['id']);
        return $this -> db -> delete('tbl_notes');
    }

}