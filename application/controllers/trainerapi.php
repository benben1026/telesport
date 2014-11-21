
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Trainerapi extends Acl_Ajax_Controller {
    public function index(){
       
    }
    private function loadResource(){
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
    public function getUserInfoById($id){
        if($id){
            $this->load->model("usermodel");
            $user = $this->usermodel->getUserInfoById($id);
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
    public function getTrainerInfo(){
        $id = $this->user['id'];
        $this->load->model('usermodel');
        $this->load->helper('url');
        $index = array('username','gender','age','firstName','lastName','occupation','nationality','firstLanguage',
        'secondLanguage','selfIntro','certType','certificate','phone','address1','passport','passport_number', 'expertise');
        $result =  $this->usermodel->getTrainerInfo($index,$id);
        if(!empty($result)){
            $segment = explode('/',$result['certificate']);
            $len = count($segment);
            $result['certificate'] = base_url($segment[$len - 2] . '/'.$segment[$len - 1]);
            $segment = explode('/',$result['passport']);
            $len = count($segment);
            $result['passport'] = base_url($segment[$len - 2] . '/'.$segment[$len - 1]);
            printJson(array('status'=>true,'result'=>$result));
        }else{
            printJson(array('status'=>false,'result'=>"No such coach"));
        }
    }

    public function getProgramList(){
        $id = $this->user['id'];
        if(!is_numeric($id)){
            printJson(array(
                'status'=>false,
                'msg'=>"Invalid id"
                ));
            return ;
        }
        $this->load->model('programmodel');
        $published = $this->programmodel->getCoachPublishedProgramList($id);
        $unpublished = $this->programmodel->getCoachUnpublishedProgramList($id);
        printJson(array(
            'status'=>true,
            'published'=>$published,
            'unpublished'=>$unpublished
        ));
    }

    function editUserInfo(){
        $this->loadResource();
        if($this->form_validation->run('editUserInfo')){
             $postData = $this->input->post();
             $user = array(
                'firstLanguage'=>$postData['firstLanguage'],
                'secondLanguage'=>$postData['secondLanguage'],
                'nationality'=>$postData['nationality'],
                'phone'=>$postData['phone'],
                'occupation'=>$postData['occupation'],
                'address1'=>$postData['address'],
            );
            $user['id'] = $this->user['id'];
            $trainer = array(
                
                'passport_number'=>$postData['passport_number'],
                'certType'=>$postData['certType'],
                'expertise'=>$postData['expertise'],
                 'selfIntro'=>$postData['selfIntro'],
            );
            $this->load->model("usermodel");
            
            if($this->usermodel->updateTrainerInfo($user,$trainer) || $this->db->_error_number()==0){
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
    
    function getUserOfProgram($id){
        if(is_numeric($id)){
            $this->load->model("programmodel");
            $result = $this->programmodel->getTraineeOfProgram($id);
            printJson(array(
                'status'=>true,
                'result'=>$result,
                ));
        }
    }
    
    function approve($enrollId, $programId){
        if(!is_numeric($enrollId) || !is_numeric($programId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
            return;
        }
        $id = $this->user['id'];
        $this->load->model("enrollmodel");
        printJson($this->enrollmodel->coachApprove($enrollId, $id, $programId));
    }
    
    function reject($enrollId, $programId){
        if(!is_numeric($enrollId) || !is_numeric($programId)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
            return;
        }
        $postData = $this->input->post();
        $reason = $postData['reason'];
        $id = $this->user['id'];
        $this->load->model("enrollmodel");
        printJson($this->enrollmodel->coachReject($enrollId, $id, $programId, $reason));
    }
}
