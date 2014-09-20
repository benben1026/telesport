<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class ACLModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getUserType($user){
        $user['email'] = isset($user["email"])? $user["email"]: NULL;
        $user['id'] = isset($user["id"])? $user["id"]: NULL;
        $sql = "SELECT userType FROM user WHERE email=? OR userId=?";
        $query = $this->db->query($sql, array($user['email'],$user['id']));
        $row = $query->row_array();
        if(!empty($row)){
            return $row['userType'];
        }else{
            return 0;
        }
    }
}