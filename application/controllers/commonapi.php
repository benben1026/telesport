
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Commonapi extends CI_Controller {
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
    public function getProgramInfo($id){
         $this->load->model("programmodel");
         $program = $this->programmodel->getProgramDetails($id);
         if(!empty($program)){
            printJson(array(
                    'status'=>true,
                    'program'=>$program
                ));
         }else{
              printJson(array(
                    'status'=>false,
                    'program'=>array()
                ));
         }
    }
    public function getProgramList($offset){
        $this->load->model('programmodel');
        if(!is_numeric($offset)){
            printJson(array(
                'status'=>false,
                'msg'=>"Invalid offset"
                ));
            return ;
        }
        $result = $this->programmodel->getProgramList($offset);
        printJson(array(
            'status'=>true,
            'list'=>$result
            ));
    }
<<<<<<< HEAD

    public function getCoachPublishedProgramList($id){
        $this->load->model('programmodel');
        if(!is_numeric($id)){
            printJson(array(
                'status'=>false,
                'msg'=>"Invalid id"
                ));
            return ;
        }
        $result = $this->programmodel->getCoachPubishedProgramList($id);
        printJson(array(
            'status'=>true,
            'list'=>$result
            ));
    }

=======
>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
    public function getTrainerInfo($id){
        #$id = $this->user['id'];
        $this->load->model('usermodel');
        $this->load->helper('url');
        $index = array('username','gender','firstName','lastName','occupation','nationality','firstLanguage',
        'secondLanguage','selfIntro');
        $result =  $this->usermodel->getTrainerInfo($index,$id);
        printJson($result);
    }
<<<<<<< HEAD


=======
>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
}