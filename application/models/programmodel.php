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
        $sql = "SELECT * ,(SELECT count(*) FROM enroll where programId = ? and enroll.statusId=0) as total FROM `program` WHERE programId=?";
        $query = $this->db->query($sql,array($programId,$programId));
        return $query->row_array();
    }
    public function getProgramList($offset){
        $sql = "SELECT program.* ,(SELECT username from user where user.userId = program.userId) as username,count(enroll.enrollId) as total,
	(SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and enroll.statusId=0) as unfinished,
	(SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and enroll.statusId=1) as finished 
	FROM `program` LEFT JOIN `enroll` ON program.programId = enroll.programId GROUP BY program.programId ORDER BY total DESC LIMIT 0,$offset";
	    $query = $this->db->query($sql);
	    return $query->result_array();
        
    }
    private function addCriteria($sql , $criteria){
        foreach($criteria as $key=>$value )
            $sql += " AND $key LIKE " + "%$value% ";
        return $sql;
    }
    
    
}