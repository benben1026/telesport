
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
        if($this->user[id]){
            $this->load->model("usermodel");
            $user = $this->usermodel->getUserInfoById($this->user[id]);
            unset($user['password']);
            unset($user['token']);
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
        if($this->form_validation->run()){
             $postData = $this->input->post();
             $user = array(
                'firstName'=>$postData['firstName'],
                'lastName'=>$postData['lastName'],
                'firstLanguage'=>$postData['firstLanguage'],
                'secondLanguage'=>$postData['secondLanguage'],
                'nationality'=>$postData['nationality'],
                'birthday'=>$postData['birthday'],
                'age'=>$postData['age'],
                'gender'=>$postData['gender'],
                'phone'=>$postData['phone'],
                'occupation'=>$postData['occupation'],
            );
            $user['id'] = $this->user['id'];
            $trainee = array(
                'height'=>$postData['height'],
                'weight'=>$postData['weight'],
                'sportsTimePerDay'=>$postData['sportsTimePerDay'],
                'ifSmoke'=>$postData['ifSmoke']==0? false : true,
                'ifDrink'=>$postData['ifDrink']==0? false: true,
                'illness' =>$postData['illness'],
                'illnessDescription'=>$postData['illnessDescription'],
                'ifMedicine'=>$postData['ifMedicine']==0?false:true,
                'medicineDescription'=>$postData['medicineDescription'],
                'ifOperation'=>$postData['ifOperation']==0?false:true,
                'operationDescription'=>$postData['operationDescription'],
                'bodyStatus'=>$postData['bodyStatus'],
                'aim'=>$postData['aim'],
            );
            $this->load->model("usermodel");
            $this->usermodel->updateTraineeInfo($user,$trainee)
        }
    }
    
}