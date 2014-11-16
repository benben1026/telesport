<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class QuestionModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function postQuestion($question){
       if($this->db->insert("question",$question)){
           	$id = $this->db->insert_id();
           	return true;
       }
       return false;
    }
}