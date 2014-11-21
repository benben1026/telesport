
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Program extends Acl_Ajax_Controller {
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
    public function createProgram(){
        
        $this->loadResource();
       
        if($this->form_validation->run('program')){
            $postData = $this->input->post();
          
            $postData['userId'] = $this->user['id'];
            $template = array();
            for($i=0;$i<intval($postData['duration']);$i++){
                $template[]=-1;
            }
            $postData['templates']=json_encode($template);
            $this->load->model('programmodel');
        
            $programId = $this->programmodel->addProgram($postData);
            if($programId){
                printJson(array(
                    'status'=>true,
                    'id'=>$programId
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
    public function updatePricePlan(){
        $this->loadResource();
        if($this->form_validation->run('pricePlan')){
           $postData = $this->input->post();
           $this->load->model('programmodel');
           $pricePlanId = $this->programmodel->addPricePlan(array(
                "fromDate"=>$postData['fromDate'],
                'toDate'=>$postData['toDate'],
                'price'=>$postData['price']
                ),$postData['programId']);
           if($pricePlanId){
                printJson(array(
                    'status'=>true,
                    'id'=>$pricePlanId
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
    public function updateProgram(){
        $this->loadResource();
        if($this->form_validation->run('updateProgram')){
            $postData = $this->input->post();
            $this->load->model('programmodel');
            $valid_update_key = array('programId','name','templates','introduction','prerequisite','goal','maxNumOfUser','duration','isPublished');
            $program = array();
            foreach($postData as $key=>$value){
                if(in_array($key,$valid_update_key)){
                    $program[$key] = $value;
                }
            }
            if($this->programmodel->updateProgram($program)){
                printJson(array(
                    'status'=>true,
                    'id'=>$postData['programId']
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
    public function deleteProgram(){
        $this->loadResource();
        if($this->form_validation->run('deleteProgram')){
            $postData = $this->input->post();
            $this->load->model("programmodel");
            if($this->programmodel->deleteProgram($postData['programId'])){
                printJson(array(
                    'status'=>true,
                    'id'=>$postData['programId']
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
            exit();
        }
    }
    public function getProgramInfo($id){
         $this->load->model("programmodel");
         $program = $this->programmodel->getProgramDetails($id);
         printJson(array(
             'status'=>true,
             'program'=>$program
             ));
    }
    public function getTemplates($id){
        $this->load->model("programmodel");
        $program = $this->programmodel->getProgramDetails($id);
        printJson(array(
            'status'=>true,
            'templates'=>$program['templates']
            ));
    }
}