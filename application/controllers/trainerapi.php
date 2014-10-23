
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
    private function getUserInfoById($id){
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
}