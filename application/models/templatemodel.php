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
        $output = array();
        $sql = "SELECT * FROM template WHERE templateId=?";
        $query = $this->db->query($sql, array($templateId));
        $data = $query->result_array();
        if(empty($data) || count($data) != 1){
            $output['RESULT'] = FALSE;
            $output['ERROR'] = "INVALID_ID";
            return $output;
        }
        //$sql = "SELECT component.componentId, generalItem.typeId, generalItem.content FROM component INNER JOIN generalItem ON component.componentId=generalItem.componentId WHERE templateId=?";
        $sql = "SELECT component.componentId, generalItem.typeId, generalItem.content, generalItemType.typeName AS itemType FROM generalItemType, component INNER JOIN generalItem ON component.componentId=generalItem.componentId WHERE templateId=? AND generalItemType.typeId=generalItem.typeId";
        $query = $this->db->query($sql, array($templateId));
        $generalItem = $query->result_array();
        $sql = "SELECT component.componentId, trainingItem.name, trainingItem.numOfSet, trainingItem.numPerSet, trainingItem.finishTime, trainingItem.remark"
                ." FROM component INNER JOIN trainingItem ON component.componentId=trainingItem.componentId WHERE templateId=?";
        $query = $this->db->query($sql, array($templateId));
        $trainingItem = $query->result_array(); 
        $order = json_decode($data[0]['componentOrder'], true);
        $component = array();
        for($i = 0; $i < count($order); $i++){
            for($j = 0; $j < count($generalItem); $j++){
                if($order[$i] == $generalItem[$j]['componentId']){
                    $component[$i] = $generalItem[$j];
                    //$output['itemType'] = $generalItem[0]['typeName'];
                    break;
                }
            }
            for($j = 0; $j < count($trainingItem); $j++){
                if($order[$i] == $trainingItem[$j]['componentId']){
                    $component[$i] = $trainingItem[$j];
                    break;
                }
            }
        }
        $output['RESULT'] = TRUE;
        $output['name'] = $data[0]['name'];
        $output['remark'] = $data[0]['remark'];
        $output['lastModified'] = $data[0]['lastModified'];
        $output['programId'] = $data[0]['programId'];
        $output['templateId'] = $templateId;
        $output['component'] = $component;

        return $output;
    }
    
    function createTemplate($programId, $userId, $name, $remark, $json_component){
        $output = array();
        if(!is_numeric($programId) || !is_numeric($userId)){
            $output['RESULT'] = FALSE;
            $output['ERROR'] = 'INVALID_ID';
            return $output;
        }
        $component = json_decode($json_component, TRUE);
        if(count($component) > 10){
            $output['RESULT'] = FALSE;
            $output['ERROR'] = 'TOO_MANY_COMPONENTS';
            return $output;
        }
        $sql = "INSERT INTO template(name, remark, programId, numOfCom, componentOrder, userId) VALUES(?, ?, ?, '0', '', ?)";
        $res = $this->db->query($sql, array($name, $remark, $programId, $userId));
        if(!$res){
            $output['RESULT'] = FALSE;
            $output['ERROR'] = 'SERVER_ERROR';
            return $output;
        }

        $sql = "SHOW TABLE status WHERE Name = 'template'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(empty($result)){
            $output['RESULT'] = FALSE;
            $output['ERROR'] = 'SERVER_ERROR';
            return $output;
        }else{
            $templateId = $result[0]['Auto_increment'] - 1;
        }
        $order = array();
        for($i = 0; $i < count($component); $i++){
            if($component[$i]['componentType'] == 'generalItem'){
                $componentId = $this->createGeneralItem($templateId, $component[$i]['type'], $component[$i]['content']);
            }else if($component[$i]['componentType'] == 'trainingItem'){
                $componentId = $this->createTrainingItem($templateId, $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
            }else{
                $output['WARNING'] = 'INVALID_TYPE:' . $component[$i]['componentType'];
                $componentId = -1;
            }
            if($componentId != -1){
                $order[$i] = $componentId;
            }
        }
        $sql = "UPDATE template SET componentOrder=?, numOfCom=? WHERE templateId = ?";
        $query = $this->db->query($sql, array(json_encode($order), $i, $templateId));
        $output['RESULT'] = TRUE;
        $output['templateId'] = $templateId;
        $output['ID'] = $order;
        return $output;
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
    
    function modifyTemplate($templateId, $userId, $name,$component){
        $output = array();
        if(!is_numeric($templateId) || !is_numeric($userId)){
            $output['status'] = FALSE;
            $output['msg'] = 'INVALID_ID';
            return $output;
        }
        //$component = json_decode($json_component, TRUE);
        if(count($component) > 10){
            $output['status'] = FALSE;
            $output['msg'] = 'TOO_MANY_COMPONENTS';
            return $output;
        }
        // $sql = "UPDATE template SET `name`=?, remark=? WHERE `templateId`=?";
        // $res = $this->db->query($sql, array($name, $remark, $templateId));
        $sql = "UPDATE template SET `name`=? WHERE `templateId`=?";
        $res = $this->db->query($sql, array($name, $templateId));

        if(!$res){
            $output['status'] = FALSE;
            $output['msg'] = 'SERVER_ERROR';
            return $output;
        }
        
        $order = array();
        for($i = 0; $i < count($component); $i++){
            if($component[$i]['componentId'] == 0){
                if($component[$i]['componentType'] == 'generalItem'){
                    $componentId = $this->createGeneralItem($templateId, $component[$i]['type'], $component[$i]['content']);
                }else if($component[$i]['componentType'] == 'trainingItem'){
                    $componentId = $this->createTrainingItem($templateId, $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
                }else{
                    $componentId = -1;
                }
                if($componentId != -1){
                    $order[$i] = "" . $componentId;
                }
            }else if($component[$i]['componentId'] > 0){
                if($component[$i]['componentType'] == 'generalItem'){
                    $res = $this->modifyGeneralItem($component[$i]['componentId'], $component[$i]['content']);
                }else if($component[$i]['componentType'] == 'trainingItem'){
                    $res = $this->modifyTrainingItem($component[$i]['componentId'], $component[$i]['name'], $component[$i]['numOfSet'], $component[$i]['numPerSet'], $component[$i]['finishTime'], $component[$i]['remark']);
                }else{
                    $res = false;
                }
                if($res){
                    $order[$i] = "" . $component[$i]['componentId'];
                }
            }else{
                $id = $component[$i]['componentId'] * (-1);
                $sql = "DELETE FROM component WHERE componentId=?";
                $query = $this->db->query($sql, array($id));
            }
        }
        $sql = "UPDATE template SET componentOrder=?, numOfCom=? WHERE templateId = ?";
        $query = $this->db->query($sql, array(json_encode($order), $i, $templateId));
        $output['status'] = TRUE;
        $output['ID'] = $order;
        return $output;
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