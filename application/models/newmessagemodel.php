<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewMessageModel extends CI_Model {
    function getNewMessage($id, $type){
        $output = array();
        $sql = "SELECT message.type, message.content,message.timestamp, message.enrollId,newTable.programId, newTable.name "
                . "FROM message LEFT JOIN "
                . "(SELECT enroll.enrollId, program.programId, program.name FROM enroll LEFT JOIN program ON enroll.programId=program.programId) AS newTable "
                . "ON newTable.enrollId=message.enrollId WHERE message.toUser=? AND (message.status=0 OR message.status=1)ORDER BY message.enrollId, message.timestamp";
        $query = $this->db->query($sql, array($id));
        $output['chat'] = $query->result_array();
        
        if($type == 1){
            /* for trainee */
            $sql = "SELECT enroll.enrollId, enroll.startDate, enroll.comment, enroll.time, program.programId, program.name, enrollStatus.text_en, enrollStatus.text_zh "
                    . "FROM enroll LEFT JOIN program ON program.programId=enroll.programId LEFT JOIN enrollStatus ON enrollStatus.id=enroll.statusId WHERE enroll.informTrainee=0 AND enroll.traineeId=? ORDER BY enroll.time";
            $query = $this->db->query($sql, array($id));
            $output['program'] = $query->result_array();
            
        }else{
            /* for trainer */
            $sql = "SELECT enroll.enrollId, enroll.statusId, enroll.programId, enroll.time, user.username, newTable.name,enrollStatus.text_en, enrollStatus.text_zh FROM enroll "
                    . "LEFT JOIN user ON user.userId=enroll.traineeId "
                    . "LEFT JOIN (SELECT * FROM program WHERE program.userId=?)AS newTable ON enroll.programId=newTable.programId "
                    . "LEFT JOIN enrollStatus ON enrollStatus.id=enroll.statusId "
                    . "WHERE enroll.informTrainer=0 ORDER BY enroll.programId, enroll.time";
            $query = $this->db->query($sql, array($id));
            $output['program'] = $query->result_array();
        }
        return array(
            'status'=>true,
            'data'=>$output,
        );
    }
    
    function setAllEnrollMsgRead($id, $type){
        if($type == 1){
            $sql = "UPDATE enroll SET informTrainee=1 WHERE traineeId=?";
            $query = $this->db->query($sql, array($id));
        }else{
            $sql = "UPDATE (SELECT * FROM enroll LEFT JOIN program ON enroll.programId=program.programId) AS newTable SET enroll.informTrainer=1 WHERE program.userId=?";
        }
    }
}