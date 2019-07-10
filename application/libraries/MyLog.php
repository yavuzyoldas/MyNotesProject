<?php
class MyLog{

    private $CI;

    public function __construct()
    {
        $this->CI =   &get_instance();
    }

    function addLog(){
        $query = $this->CI->db->get('notes');
        var_dump($query->result_array());
    }
}