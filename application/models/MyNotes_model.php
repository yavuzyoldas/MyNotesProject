<?php
class MyNotes_model extends CI_Model {

    public function getAllNotesForUser($userId)
    {
        $this->db->where("userid",$userId);
        $this ->db -> select("id,title,content,date");
        $query = $this->db->get('tbl_notes');
        $response = $query->result_array();
        return $response;
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