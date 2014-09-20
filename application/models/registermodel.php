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
       $a =  $this->db->insert("user",$data);
       return $a;
    }
    function checkDuplicate($email){
        $sql = "SELECT * FROM `user` WHERE `email` = ?";
        $query =  $this->db->query($sql,array($email));
        if($query && $query->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
}