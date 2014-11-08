
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
         printJson(array(
             'status'=>true,
             'program'=>$program
             ));
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
}