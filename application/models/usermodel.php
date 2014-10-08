<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class UserModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function getUserById($id){
        $sql = "SELECT * FROM user WHERE userId = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }
}