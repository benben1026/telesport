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
        $this->db->update("program",$program);
        return $this->db->affected_rows();
        
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
        $sql = "SELECT * ,(SELECT count(*) FROM enroll where programId = ? and (enroll.statusId=3 OR enroll.statusId=4 OR enroll.statusId=5 OR enroll.statusId=6)) as total FROM `program` WHERE programId=?";

        $query = $this->db->query($sql,array($programId,$programId));
        return $query->row_array();
    }
    public function getProgramList($offset){
        $sql = "SELECT program.* ,(SELECT username from user where user.userId = program.userId) as username,count(enroll.enrollId) as total,
	(SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and (enroll.statusId=3 OR enroll.statusId=4 OR enroll.statusId=5 OR enroll.statusId=6)) as unfinished,
	(SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and enroll.statusId=7) as finished 
	FROM `program` LEFT JOIN `enroll` ON program.programId = enroll.programId GROUP BY program.programId ORDER BY total DESC LIMIT 0,$offset";
	    $query = $this->db->query($sql);
	    return $query->result_array();
        
    }
    public function getCoachPublishedProgramList($id){
        $sql = "SELECT program.*, 	
        (SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and (enroll.statusId=3 OR enroll.statusId=4 OR enroll.statusId=5 OR enroll.statusId=6)) as unfinished, 
        (SELECT count(*) FROM `enroll` WHERE enroll.programId=program.programId and (enroll.statusId=1)) as applicant 
        FROM program WHERE userId=? AND isPublished=1 ORDER BY lastModified DESC";
        $query = $this->db->query($sql, array(intval($id)));
        return $query->result_array();
    }
    
    public function getCoachUnpublishedProgramList($id){
        $sql = "SELECT * FROM program WHERE userId=? AND isPublished=0 ORDER BY lastModified";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    private function addCriteria($sql , $criteria){
        foreach($criteria as $key=>$value )
            $sql += " AND $key LIKE " + "%$value% ";
        return $sql;
    }
    public function getTraineeOfProgram($id){
        $sql = "SELECT enroll.*,username,firstName,lastName,gender from enroll join user on user.userId = trainee.userId where programId=? order by time ASC";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }
    
}