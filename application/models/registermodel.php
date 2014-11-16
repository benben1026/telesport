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
    function register($user,$trainee){
       if($this->db->insert("user",$user)){
           $id = $this->db->insert_id();
           $trainee['userId'] = $id;
           if($this->db->insert("trainee",$trainee)){
               return true;
           }
       }
       return false;
    }
    function trainer($user,$trainer){
       if($this->db->insert("user",$user)){
           $id = $this->db->insert_id();
           $trainer['userId'] = $id;
           if($this->db->insert("trainer",$trainer)){
               return true;
           }
       }
       return false;
    }
<<<<<<< HEAD
    function checkEmailDuplicate($email){
        $sql = "SELECT * FROM `user` WHERE `email` = ?";
        $query =  $this->db->query($sql,array($email));
        if($query && $query->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

    function checkUsernameDuplicate($username){
        $sql = "SELECT * FROM `user` WHERE `username` = ?";
        $query =  $this->db->query($sql,array($username));
        if($query && $query->num_rows()>0){
=======
    function checkDuplicate($email){
        $sql = "SELECT * FROM `user` WHERE `email` = ?";
        $query =  $this->db->query($sql,array($email));
        if($query && $query->num_rows()>0){

>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
            return true;
        }else{
            return false;
        }
    }
<<<<<<< HEAD
=======

>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
}