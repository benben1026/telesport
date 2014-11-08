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

    function checkLogin($email, $password){
        $sql = "SELECT userId, password, isVerified, userType,username FROM user WHERE email=?";
        $query = $this->db->query($sql, array($email));
        $row = $query->result_array();
        if(!empty($row) && $row[0]['isVerified'] == 0){
            return array(
                'status'=>false,
                'code'=>-2,
                'msg'=>"Not verified"
                );
        }else if(!empty($row) && $row[0]['password'] == md5(md5($password))){
            $this->setLogin($row[0]['userId'],$row[0]['userType']);
            return array(
                'status'=>true,
                'code'=>1,
                'userName'=>$row[0]['username'],
                'userType'=>$row[0]['userType'],
                'userId'=>$row[0]['userId'],
                'msg'=>""
            );
        }else{
            return array(
                'status'=>false,
                'code'=>-1,
                'msg'=>"User does not exists"
            );
        }
    }
    
    function rememberMe($email){
        $this->load->helper('cookie');
        $rand = rand();
        $sql = "SELECT `userId`, `password`,`userType` FROM `user` WHERE `email`=?";
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
                $cookie = array(
                    'name'   => 'USER_ID',
                    'value'  => $id,
                    'expire' => '86500'
                );
                $this->input->set_cookie($cookie);
                $this->setLogin($row[0]['userId'],$row[0]['userType']);
                return 1;
            }else{
                return -2;
            }
        }else{
            return -1;
        }
    }
    
    function autoLogin($id, $cookie){
        $sql = "SELECT `email`, `password`, `token`,`userType` FROM `user` WHERE `userId`=?";
        $query = $this->db->query($sql, array($id));
        $row = $query->result_array();
        if(!empty($row)){
            $trueCookie = hash('ripemd256', $row[0]['email'] . $row[0]['password'] . $row[0]['token']);
            if($trueCookie == $cookie){
                $this->setLogin($row[0]['userId'],$row[0]['userType']);
                return true;
            }
        }
        //delete_cookie("USER_LOGIN");
        return false;
    }
    function setLogin($userId,$userType){
        $newData = array(
            'userId'=>$userId,
            'userType'=>$userType,
            'isLogin'=>true,
        );
        $this->session->set_userdata($newData);
    }
    function logout(){
        delete_cookie("USER_LOGIN");
        delete_cookie("USER_ID");
        $this->session->sess_destroy();
    }

}