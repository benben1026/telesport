<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class ProgramModel extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function addProgram($program){
        $this->db->insert("program",$program);
        return $this->db->insert_id();
    }
    function addPricePlan($pricePlan,$programId){
       
        $this->db->insert("pricePlan",$pricePlan);
        $pricePlanId = $this->db->insert_id();
        $programUpdate = array(
                'pricePlanId'=>$pricePlanId,
            );
        $this->db->where('programId',$programId);
        $this->db->update("program",$programUpdate);
        
        return $pricePlanId;
    }
    function updateProgram($program){
        $this->db->where("programId",$program['programId']);
        return  $this->db->update("program",$program);
        
    }
    function deleteProgram($programId){
        $this->db->where("programId",$programId);
        return $this->db->delete("program");
    }
    function searchProgram($program){
        $this->db->or_like($program);
        $this->db->select("programId");
        $this->db->from("program");
        return $this->db->get();
    }
    function getProgramDetails($programId){
        $this->db->select("*");
        $this->db->where('programId',$programId);
        $this->db->from("program");
        return $this->db->get();
    }
    function searchProgram(){
        
    }
    
}