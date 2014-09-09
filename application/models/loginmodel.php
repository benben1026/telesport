<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class LoginModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function login($email, $password){
        $sql = "SELECT userId, password FROM user WHERE email=?";
        $query = $this->db->query($sql, $email);
        $row = $query->result_array();
        if(isset($row) && $row['password'] == md5(md5($password))){
            $newdata = array(
                'userId'=>$row['userId'],
                'ifLogin'=>true,
            );
            $this->session->set_userdata($newdata);
            return true;
        }else{
            return false;
        }
    }


}