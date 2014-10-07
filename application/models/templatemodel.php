<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TemplateModel extends CI_Model {
    function getTemplate($userId, $programId){
        $sql = "SELECT `templateId`, `name`, `lastModified`, `programId` FROM template WHERE userId=?";
        $query = $this->db->query($sql, array($userId));
        $row = $query->result_array();
        if(empty($row)){
            return array();
        }
        if($programId != 0){
            $new = array();
            $previous = array();
            $j = 0;
            $k = 0;
            for($i = 0 ; $i < count($row); $i++){
                if($row[$i]['programId'] == $programId){
                    $new[$j]['templateId'] = $row[$i]['templateId'];
                    $new[$j]['name'] = $row[$i]['name'];
                    $new[$j]['lastModified'] = $row[$i]['lastModified'];
                    $j++;
                }else{
                    $previous[$k]['templateId'] = $row[$i]['templateId'];
                    $previous[$k]['name'] = $row[$i]['name'];
                    $previous[$k]['lastModified'] = $row[$i]['lastModified'];
                    $k++;
                }
            }
        }else{
            $new = array();
            $previous = array();
            $j = 0;
            $k = 0;
            for($i = 0;$i < count($row); $i++){
                $previous[$k]['templateId'] = $row[$i]['templateId'];
                $previous[$k]['name'] = $row[$i]['name'];
                $previous[$k]['lastModified'] = $row[$i]['lastModified'];
                $k++;
            }
        }
        $result = array();
        $result['PREVIOUS_TEMPLATE'] = $previous;
        $result['NEW_TEMPLATE'] = $new;
        return $result;
    }
    
    function getDetailedTemplate($templateId){
        $sql = "SELECT * FROM tempalte WHERE templateId=?";
        $query = $this->db->query($sql, array($templateId));
        $data = $query->result_array();
        if(!empty($data) && count($data) == 1){
            $sql = "SELECT component.componentId, generalItem.typeId, generalItem.content FROM component INNER JOIN generalItem ON component.componentId=generalItem.componentId WHERE templateId=?";
            $query = $this->db->query($sql, array($templateId));
            $generalItem = $query->result_array();
            $sql = "SELECT component.componentId, trainingItem.name, trainingItem.numOfSet, trainingItem.numPerSet, trainingItem.finishTime, trainingItem.remark"
                    ."FROM component INNER JOIN trainingItem ON component.componentId=trainingItem.componentId WHERE templateId=?";
            $query = $this->db->query($sql, array($templateId));
            $trainingItem = $query->result_array(); 
            
        }
    }
    
    function createTemplate($programId, $userId, $name, $remark, $json_component){
        $sql = "INSERT INTO template(name, remark, programId, numOfCom, componentOrder, userId) VALUES(?, ?, ?, '0', '', ?)";
        $res = $this->db->query($sql, array($name, $remark, $programId, $userId));
        if(!$res){
            return false;
        }
        $sql = "SHOW TABLE status WHERE Name = 'template'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(empty($result)){
            return false;
        }else{
            $templateId = $result[0]['Auto_increment'] - 1;
        }
        $component = json_decode($json_component, TRUE);
        $order = array();
        for($i = 0; $i < count($component); $i++){
            if($component[$i]['componentType'] == 'generalItem'){
                $componentId = $this->createGeneralItem($templateId, $component[$i]['type'], $component[$i]['content']);
            }else if($component[$i]['componentType'] == 'trainingItem'){
                $componentId = $this->createTrainingItem($templateId, $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
            }else{
                $error = "ERROR";
            }
            if($componentId != -1){
                $order[$i] = $componentId;
            }
        }
        $sql = "UPDATE template SET componentOrder=?, numOfCom=? WHERE templateId = ?";
        $query = $this->db->query($sql, array(json_encode($order), $i, $templateId));
        return $order;
    }
    
    function createComponent($componentType, $templateId){
        $sql = "INSERT INTO component(componentType, templateId) VALUES(?, ?)";
        $res = $this->db->query($sql, array($componentType, $templateId));
        if($res){
            $sql = "SHOW TABLE status WHERE Name = 'component'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            if(!empty($result)){
                return $result[0]['Auto_increment'] - 1;
            }
        }
        return -1;
    }
    
    function createGeneralItem($templateId, $type, $content){
        $sql = "SELECT * FROM generalItemType WHERE typeName=?";
        $query = $this->db->query($sql, array($type));
        $result = $query->result_array();
        if(!empty($result)){
            $componentId = $this->createComponent(1, $templateId);
            if($componentId == -1){
                return -1;
            }
            $sql = "INSERT INTO generalItem(componentId, typeId, content) VALUES(?, ?, ?)";
            $res = $this->db->query($sql, array($componentId, $result[0]['typeId'], $content));
            return $res ? $componentId : false;
        }
        return false;
    }
    
    function createTrainingItem($templateId, $name, $numOfSet, $numPerSet, $finishTime, $remark){
        if(!is_numeric($numOfSet) || !is_numeric($numPerSet)){
            return -1;
        }
        $componentId = $this->createComponent(2, $templateId);
        if($componentId == -1){
            return -1;
        }
        $sql = "INSERT INTO trainingItem(componentId, name, numOfset, numPerSet, finishTime, remark) VALUES(?, ?, ?, ?, ?, ?)";
        $res = $this->db->query($sql, array($componentId, $name, $numOfSet, $numPerSet, $finishTime, $remark));
        return $res ? $componentId : false;
    }
    
    function modifyTemplate($templateId, $userId, $name, $remark, $json_component){
        if(!isset($templateId)){
            return false;
        }
        $sql = "UPDATE template SET `name`=?, remark=? WHERE `templateId`=?";
        $res = $this->db->query($sql, array($name, $remark, $templateId));
        if(!$res){
            return false;
        }
        
        $component = json_decode($json_component, TRUE);
        $order = array();
        for($i = 0; $i < count($component); $i++){
            if($component[$i]['componentId'] == -1){
                if($component[$i]['componentType'] == 'generalItem'){
                    $componentId = $this->createGeneralItem($templateId, $component[$i]['type'], $component[$i]['content']);
                }else if($component[$i]['componentType'] == 'trainingItem'){
                    $componentId = $this->createTrainingItem($templateId, $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
                }else{
                    $componentId = -1;
                }
                if($componentId != -1){
                    $order[$i] = $componentId;
                }
            }else{
                if($component[$i]['componentType'] == 'generalItem'){
                    $res = $this->modifyGeneralItem($component[$i]['componentId'], $component[$i]['content']);
                }else if($component[$i]['componentType'] == 'trainingItem'){
                    $res = $this->modifyTrainingItem($component[$i]['componentId'], $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
                }else{
                    $res = false;
                }
                if($res){
                    $order[$i] = $component[$i]['componentId'];
                }
            }
        }
        return $order;
    }
    
    function modifyGeneralItem($componentId, $content){
        if(isset($componentId)){
            $sql = "UPDATE generalItem SET `content`=? WHERE `componentId`=?";
            $res = $this->db->query($sql, array($content, $componentId));
            if($res){
                return true;
            }
        }
        return false;
    }
    
    function modifyTrainingItem($componentId, $name, $numOfSet, $numPerSet, $finishTime, $remark){
        if(isset($componentId)){
            $sql = "UPDATE trainingItem SET `name`=?, `numOfSet`=?, `numPerSet`=?, `finishTime`=?, `remark`=? WHERE `componentId`=?";
            $res = $this->db->query($sql, array($name, $numOfSet, $numPerSet, $finishTime, $remark, $componentId));
            if($res){
                return true;
            }
        }
        return false;
    }
    
    function delete($templateId, $userId){
        $sql = "DELETE FROM `template` WHERE templateId=? AND userId=?";
        $result = $this->db->query($sql, array($templateId, $userId));
        return $result;
    }
}