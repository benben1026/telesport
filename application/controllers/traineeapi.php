
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Traineeapi extends Acl_Ajax_Controller {
    public function index(){
       
    }
    function loadResource(){
        $this->load->library('form_validation');
        $this->load->library("Tele_Form_validation");
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');
        $postData = $this->input->post();
        if(empty($postData)){
            show_404();
            exit;
        }
    }
    function getUserInfo(){
        if($this->user['id']){
            $this->load->model("usermodel");
            $user = $this->usermodel->getUserInfoById($this->user['id']);
            printJson(array(
                "status"=>true,
                "userInfo"=>$user,
                ));
        }else{
            printJson(array(
                "status"=>false,
                ));
        }
    }
    function editUserInfo(){
        $this->loadResource();
        if($this->form_validation->run('editUserInfo')){
             $postData = $this->input->post();
             $user = array(
                'age'=>$postData['age'],
                //'gender'=>$postData['gender'],
            );
            $user['id'] = $this->user['id'];
            $trainee = array(
                'height'=>$postData['height'],
                'weight'=>$postData['weight'],
                'sportsTimePerDay'=>$postData['sportsTimePerDay'],
                'ifSmoke'=>$postData['ifSmoke']==0? false : true,
                'ifDrink'=>$postData['ifDrink']==0? false: true,
                //'illness' =>$postData['illness'],
                'illnessDescription'=>$postData['illnessDescription'],
              
                'medicineDescription'=>$postData['medicineDescription'],
                
                'operationDescription'=>$postData['operationDescription'],
                'aim'=>$postData['aim'],
            );
            $this->load->model("usermodel");
            
            if($this->usermodel->updateTraineeInfo($user,$trainee) || $this->db->_error_number()==0){
                  printJson(array(
                   'status'=>true,
                ));
            }else{
                 printJson(array(
                    'status'=>false,
                    'errorCode'=>$this->db->_error_number(),
                ));
            }
        }else{
            $errors = form_error();
            printJson(array(
                'status'=>false,
                'errors'=>$errors,
            ));
        }
    }
    
    function getProgramList(){
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->getProgramList($id));
    }
    
    function apply($programId){
        if(!is_numeric($programId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
        }
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->apply($programId, $id));
    }
    
    function payment($enrollId){
        if(!is_numeric($enrollId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
        }
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->payment($enrollId, $id));
    }
    
    function startProgram($enrollId){
        if(!is_numeric($enrollId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
        }
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->startProgram($enrollId, $id));
    }
    
    function finishProgram($enrollId){
        if(!is_numeric($enrollId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
        }
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->finishProgram($enrollId, $id));
    }
    
    function exitProgram($enrollId){
        if(!is_numeric($enrollId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
        }
        $id = $this->user['id'];
        $this->load->model('enrollmodel');
        printJson($this->enrollmodel->exitProgram($enrollId, $id));
    }

    function getNewMessage(){
        $id = $this->user['id'];
        $type = $this->user['type'];
        $this->load->model('newmessagemodel');
        printJson($this->newmessagemodel->getNewMessage($id, $type));
    }

    function setMsgRead($msgList){
        $id = $this->user['id'];
        $type = $this->user['type'];
        $postData = $this->input->post();
        $this->load->model('newmessagemodel');
        if($type == 1){
            printJson($this->newmessagemodel->setTrainerRead($id, $msgList));
        }else{
            printJson($this->newmessagemodel->setTraineeRead($id, $msgList));
        }
    }
}