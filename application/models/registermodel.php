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
               return $id;
           }
       }
       return false;
    }
    function trainer($user,$trainer){
       if($this->db->insert("user",$user)){
           $id = $this->db->insert_id();
           $trainer['userId'] = $id;
           if($this->db->insert("trainer",$trainer)){
               return $id;
           }
       }
       return false;
    }
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
            return true;
        }else{
            return false;
        }
    }
}