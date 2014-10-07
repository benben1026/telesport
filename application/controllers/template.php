<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {
    public function index(){
        $postData = $this->input->post();
        $this->load->model("templatemodel");
        if($postData['type'] == 1){
            if(isset($postData['programId'])){
                $this->getTemplate($postData['userId'], $postData['programId']);
            }else{
                $this->getTemplate($postData['userId'], 0);
            }
        }else if($postData['type'] == 2){
            $this->getDetailedTemplate($postData['templateId']);
        }else if($postData['type'] == 3){
            //create
            if(!isset($postData['programId'])){
                $output = array(
                    'RESULT'=>FALSE
                );
                $this->output($output);
            }
            $this->createTemplate($postData['programId'], $postData['userId'], $postData['name'], $postData['remark'], $postData['component']);
        }else if($postData['type'] == 4){
            //modify
            if(!isset($postData['templateId'])){
                $output = array(
                    'RESULT'=>FALSE
                );
                $this->output($output);
            }
            $this->modifyTemplate($postData['templateId'], $postData['userId'], $postData['name'], $postData['remark'], $postData['component']);
        }else if($postData['type'] == 5){
            //delete
            if(isset($postData['templateId']) && isset($postData['userId'])){
                $this->delete($postData['templateId'], $postData['userId']);
            }else{
                $output = array(
                    'RESULT'=>FALSE
                );
                $this->output($output);
            }
        }else{
            
        }
    }
    
    public function getTemplate($userId, $programId){
        $result = $this->templatemodel->getTemplate($userId, $programId);
        $this->output($result);
        return;
    }
    
    public function getDetailedTemplate($templateId){
        
    }
    
    public function createTemplate($programId, $userId, $name, $remark, $json_component){
        if(empty($programId) || empty($userId)){
            $output = array(
                'RESULT'=>TRUE
            );
            $this->output($output);
            return;
        }
        $order = $this->templatemodel->createTemplate($programId, $userId, $name, $remark, $json_component);
        if($order != false){
            $output = array(
                'RESULT'=>TRUE,
                'ID'=>$order
            );
            $this->output($output);
        }else{
            $output = array(
                'RESULT'=>FALSE
            );
            $this->output($output);
        }
    }
    
    public function modifyTemplate($templateId, $userId, $name, $remark, $json_component){
        $order = $this->templatemodel->modifyTemplate($templateId, $userId, $name, $remark, $json_component);
        if($order != false){
            $output = array(
                'RESULT'=>TRUE,
                'ID'=>$order
            );
            $this->output($output);
        }else{
            $output = array(
                'RESULT'=>FALSE
            );
            $this->output($output);
        }
    }
    
    function delete($templateId, $userId){
        if($this->templatemodel->delete($templateId, $userId)){
            $output = array(
                'RESULT'=>TRUE
            );
            $this->output($output);
        }else{
            $output = array(
                'RESULT'=>FALSE
            );
            $this->output($output);
        }
    }
    
    function output($res){
        printJson($res);
    }
}

