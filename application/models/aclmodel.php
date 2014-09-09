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

    function getUserType($email){
        $sql = "SELECT userType FROM user WHERE email=?";
        $query = $this->db->query($sql, $email);
        $row = $query->row_array();
        if(!empty($row)){
            return $row['userType'];
        }else{
            return 0;
        }
    }


}