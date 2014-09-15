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
        $sql = "SELECT userId, password, isVarified FROM user WHERE email=?";
        $query = $this->db->query($sql, $email);
        $row = $query->result_array();
        if(!empty($row) && $row[0]['isVarified'] == 0){
            return -2;
        }else if(!empty($row) && $row[0]['password'] == md5(md5($password))){
            $newdata = array(
                'userId'=>$row[0]['userId'],
                'isLogin'=>true,
            );
            $this->session->set_userdata($newdata);
            return 1;
        }else{
            return -1;
        }
    }
    
    function rememberme($email){
        $this->load->helper('cookie');
        $rand = rand();
        $sql = "SELECT `userId`, `password` FROM `user` WHERE `email`=?";
        $query = $this->db->query($sql, array($email));
        $row = $query->result_array();
        if(!empty($row)){
            $id = $row[0]['userId'];
            $password = $row[0]['password'];
            $sql = "UPDATE `user` SET `token`=? WHERE `email`=?";
            if($this->db->query($sql, array($rand, $email))){
                $hash = hash('ripemd256', $email . $password . $rand);
                $cookie = array(
                    'name'   => 'USER_LOGIN',
                    'value'  => $hash,
                    'expire' => '86500'
                );
                $this->input->set_cookie($cookie);
                $newdata = array(
                    'userId'=>$row[0]['userId'],
                    'isLogin'=>true,
                );
                $this->session->set_userdata($newdata);
                return 1;
            }else{
                return -2;
            }
        }else{
            return -1;
        }
    }
    
    function autoLogin($id, $cookie){
        $sql = "SELECT `email`, `password`, `token` FROM `user` WHERE `userId`=?";
        $query = $this->db->query($sql, array($id));
        $row = $query->result_array();
        if(!empty($row)){
            $trueCookie = hash('ripemd256', $row[0]['email'] . $row[0]['password'] . $row[0]['token']);
            if($trueCookie == $cookie){
                return true;
            }
        }
        //delete_cookie("USER_LOGIN");
        return false;
    }

}