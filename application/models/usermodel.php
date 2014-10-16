<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class UserModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function getUserById($id){
        $sql = "SELECT * FROM user WHERE userId = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }
    function setToken($email){
        $this->load->helper("stringext");
        $token = generateToken();
        $update = array(
                "token"=>$token,
            );
        $this->db->where("email",$email);
        $this->db->update("user",$update);
        
        if($this->db->affected_rows()!=0){
            return $token;
        }else{
            return false;
        }
    }
    function sendEmail($fromEmail,$toEmail,$subject,$content){
        echo "here";
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($fromEmail, 'Bruce');
        $this->email->to($toEmail); 
        $this->email->subject($subject);
        $this->email->message($content);	
        $this->email->send();
    }
}