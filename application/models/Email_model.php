<?php


class Email_model extends CI_Model
{

    public function isValidEmail($email){
        $this->db->where("email",$email);
        if ($this->db->get('tbl_users')->num_rows() != 0)
            return false;

        return true;
    }

    public function sendToActivationEmail($activation_code,$email){


        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'infomynotes1@gmail.com',
            'smtp_pass' => 'mynotes123',
            'starttls'  => true,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => true
        );


        $message = "MyNotes uygulamasını kullanabilmek için lütfen bağlantıya tıklayınız." ;
        $link = "http://localhost/mynotes/Users/insert?k=";
        $activation_message = $message." "."</br>"." ".$link.$activation_code;
        $this->load->library("email");
        $this->email->initialize($config);

        $this -> email -> from('infomynotes1@gmail.com','MyNotes Aktivasyon');

        $this -> email -> to($email);

        $this -> email->subject("Aktivasyon E-Postası");

        $this -> email -> message($activation_message);

        $this->email->set_newline("\r\n");

         return $this -> email -> send();

        echo $this -> email ->print_debugger();


        }





}