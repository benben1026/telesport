<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {
    public function index(){
        $postData = $this->input->post();
        $this->load->model("templatemodel");
        if($postData['type'] == 1){
            if(isset($postData['userId'], $postData['programId'])){
                $this->getTemplateList($postData['userId'], $postData['programId']);
            }else if(isset($postData['userId'])){
                $this->getTemplateList($postData['userId'], 0);
            }else{
                $output = array(
                    'RESULT'=>FALSE,
                    'ERROR'=>'INVALID_PARAMETER'
                );
                $this->output($output);
            }
        }else if($postData['type'] == 2){
            if(isset($postData['templateId'])){
                $this->getDetailedTemplate($postData['templateId']);
            }else{
                $output = array(
                    'RESULT'=>FALSE,
                    'ERROR'=>'INVALID_PARAMETER'
                );
                $this->output($output);
            }
        }else if($postData['type'] == 3){
            //create
            if(isset($postData['programId'], $postData['userId'], $postData['name'], $postData['remark'], $postData['component'])){
                $this->createTemplate($postData['programId'], $postData['userId'], $postData['name'], $postData['remark'], $postData['component']);
            }else{
                $output = array(
                    'RESULT'=>FALSE,
                    'ERROR'=>'INVALID_PARAMETER'
                );
                $this->output($output);
            }
        }else if($postData['type'] == 4){
            //modify
            if(isset($postData['templateId'])){
                $this->modifyTemplate($postData['templateId'], $postData['userId'], $postData['name'], $postData['remark'], $postData['component']);
            }else{
                $output = array(
                    'RESULT'=>FALSE,
                    'ERROR'=>'INVALID_PARAMETER'
                );
                $this->output($output);
            }
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
            $output = array(
                'RESULT'=>FALSE,
                'ERROR'=>'INVALID_PARAMETER'
            );
            $this->output($output);
        }
    }
    
    public function getTemplateList($userId, $programId){
        $this->output($this->templatemodel->getTemplate($userId, $programId));
        return;
    }
    
    public function getDetailedTemplate($templateId){
        $this->output($this->templatemodel->getDetailedTemplate($templateId));
        return;
    }
    
    public function createTemplate($programId, $userId, $name, $remark, $json_component){
        $this->output($this->templatemodel->createTemplate($programId, $userId, $name, $remark, $json_component));
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
    function uploadFile(){
        
    }
}

