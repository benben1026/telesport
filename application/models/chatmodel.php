<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ChatModel extends CI_Model {
    function setReadMsg($json_readMsg){
        $output = array();
        $readMsg = json_decode($json_readMsg, TRUE);
        if(empty($readMsg)){
            return 'EMPTY';
            //$output['SETREADMSG'] = 'EMPTY';
            //return $output; 
        }
        for($i = 0; $i < count($readMsg); $i++){
            $sql = "UPDATE message SET status = '2' WHERE messageId = ?";
            $query = $this->db->query($sql, array($readMsg[$i]));
        }
        //$output['SETREADMSG'] = 'EMPTY';
        //return $output; 
        return TRUE;
    }
    
    function sendMsg($fromUser, $toUser, $content, $type, $enrollId){
        $output = array();
        $sql = "INSERT INTO message(content, type, fromUser, toUser, enrollId) VALUES(?,?,?,?,?)";
        $query = $this->db->query($sql, array($content, $type, $fromUser, $toUser, $enrollId));
        if($query){
            //$output['SENDMSG'] = TRUE;
            return TRUE;
        }else{
            //$output['SENDMSG'] = FALSE;
            return FALSE;
        }
        //return $output;
    }
    
    function getMsg($fromUser, $toUser, $enrollId){
        $output = array();
        $msg = array();
        $sql = "SELECT * FROM message WHERE enrollId=? AND fromUser=? AND toUser=? AND status=?";
        $query = $this->db->query($sql, array($enrollId, $toUser, $fromUser, 0));
        $row = $query->result_array();
        if(empty($row)){
            //$output['NEWMSG'] = [];
            //return $output;
            return [];
        }
        for($i = 0; $i < count($row); $i++){
            $msg[$i]['MSGID'] = $row[$i]['messageId'];
            $msg[$i]['TYPE'] = $row[$i]['type'];
            $msg[$i]['CONTENT'] = $row[$i]['content'];
            $msg[$i]['TIME'] = $row[$i]['timestamp'];
            $sql = "UPDATE message SET status = '1' WHERE messageId = ?";
            $query = $this->db->query($sql, array($row[$i]['messageId']));
        }
        return $msg;
        //$output['NEWMSG'] = $msg;
        //return $output;
    }
    
    function getHistory($userId, $enrollId, $messageId, $offset){
        $constrain = "";
        if($messageId != 0){
            $constrain = "AND messageId < " . $messageId;
        }
        $sql = "SELECT * FROM message WHERE enrollId=? " . $constrain . " AND (fromUser=? OR toUser=?) ORDER BY timestamp DESC LIMIT ?";
        $query = $this->db->query($sql, array($enrollId, $userId, $userId, $offset));
        $row = $query->result_array();
        $output = array(
            'status'=>true,
            'data'=>$row,
        );
    }
}