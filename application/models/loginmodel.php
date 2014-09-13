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

    function checklogin($email, $password){
        $sql = "SELECT userId, password FROM user WHERE email=?";
        $query = $this->db->query($sql, $email);
        $row = $query->result_array();
        if(isset($row) && $row['password'] == md5(md5($password))){
            $newdata = array(
                'userId'=>$row['userId'],
                'isLogin'=>true,
            );
            $this->session->set_userdata($newdata);
            return true;
        }else{
            return false;
        }
    }
    
    function rememberme($email){
        $this->load->helper('cookie');
        $rand = rand();
        $sql = "SELECT userId, password FROM user WHERE email=?";
        $query = $this->db->query($sql, $email);
        $row = $query->result_array();
        if(isset($row)){
            $id = $row['userId'];
            $password = $row['password'];
            $sql = "INSERT INTO user SET token=? WHERE email=?";
            $this->db->query($sql, $rand, $email);
            $hash = hash('ripemd256', $email . $password . $rand);
            $cookie = array(
                'name'   => 'USER_LOGIN',
                'value'  => $hash,
                'expire' => '86500'
            );
            $this->input->set_cookie($cookie);
            return $id;
        }else{
            return -1;
        }
    }
    
    function autoLogin($id, $cookie){
        $sql = "SELECT email, password, token FROM user WHERE userId=?";
        $query = $this->db->query($sql, $id);
        $row = $query->result_array();
        if(isset($row)){
            $trueCookie = hash('ripemd256', $row['email'] . $row['password'] . $row['token']);
            if($trueCookie == $cookie){
                return true;
            }
        }
        delete_cookie("USER_LOGIN");
        return false;
    }

}