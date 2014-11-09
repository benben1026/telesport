
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
        $index = array('username','gender','firstName','lastName','occupation','nationality','firstLanguage',
        'secondLanguage','selfIntro','certType','certificate','phone','address1','passport','passport_number');
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
}