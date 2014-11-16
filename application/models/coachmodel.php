<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CoachModel extends CI_Model {
    function getCoachList(){
        $output = array();
        $sql = "SELECT trainer.userId, trainer.expertise, user.rank, user.firstName, user.lastName FROM trainer INNER JOIN user ON user.userId=trainer.userId ORDER BY user.rank DESC";
        $query = $this->db->query($sql);
        $row = $query->result_array();
        if(!empty($row)){
            for($i = 0; $i < count($row); $i++){
                $sql = "SELECT programId, name, lastModified FROM program WHERE userId=? ORDER BY lastModified";
                $query = $this->db->query($sql, array($row[$i]['userId']));
                $pro = $query->result_array();
                if(!empty($pro)){
                    $row[$i]['programId'] = $pro[0]['programId'];
                    $row[$i]['programName'] = $pro[0]['name'];
                    $row[$i]['lastModified'] = $pro[0]['lastModified'];
                }
            }
            $output['RESULT'] = TRUE;
            $output['TRAINER'] = $row;
        }else{
            $output['RESULT'] = FALSE;
        }
        return $output;
    }
}