<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class RegisterModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   function register($data){
       return $this->db->insert("users",$data);
   }
   function getUserInfo(){
       return array(
           "username"=>"bruce",
           "password"=>"password",
           "message"=>"dwadwada"

       );
   }

}