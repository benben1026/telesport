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

   function getUserInfo(){
       return array(
           "username"=>"bruce",
           "password"=>"password",
           "message"=>"dwadwada"

       );
   }

}