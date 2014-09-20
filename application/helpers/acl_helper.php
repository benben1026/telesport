<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/9/14
 * Time: 3:18 PM
 */
if ( ! function_exists('checkLogin')){
    function checkLogin(){
        $ci  =& get_instance();
        if($ci->session->userdata("isLogin")){
            return $ci->session->userdata("email");
        }else{
            return false;
        }

    }

}

    
    function isLogin(){
        $ci  =& get_instance();
        if($ci->session->userdata("isLogin")){
            return $ci->session->userdata("userId");
        }
        $loginCookie = $this->input->get_cookie('USER_LOGIN');
        $idCookie = $this->input->get_cookie('USER_ID');
        if(!empty($loginCookie) && !empty($idCookie)){
            $sql = "SELECT `email`, `password`, `token` FROM `user` WHERE `userId`=?";
            $query = $this->db->query($sql, array($idCookie));
            $row = $query->result_array();
            if(!empty($row)){
                $trueCookie = hash('ripemd256', $row[0]['email'] . $row[0]['password'] . $row[0]['token']);
                if($trueCookie == $loginCookie){
                    return $idCookie;
                }
            }
        }
        return false;
    }