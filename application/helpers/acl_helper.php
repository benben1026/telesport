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