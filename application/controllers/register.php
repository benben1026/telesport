<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function index(){
       // print_r( $this->session->all_userdata());
    }
	public function ajaxRegister()
	{
        $this->load->library('form_validation');
        $this->load->library("Tele_Form_validation");
        $postData = $this->input->post();

        if(empty($postData)){
            show_404();
        }
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('register')){
            $postData = $this->input->post();
            $this->load->model('registermodel');
            $user = array(
                'firstName'=>$postData['firstName'],
                'lastName'=>$postData['lastName'],
                'email'=>$postData['email'],
                'password'=>md5(md5($postData['password'])),
                'firstLanguage'=>$postData['firstLanguage'],
                'secondLanguage'=>$postData['secondLanguage'],
                'nationality'=>$postData['nationality'],
                'birthday'=>$postData['birthday'],
                'balance'=>DEFAULT_BALANCE,
                'userType'=>TRAINEE,
                'rank'=>DEFAULT_RANK,
                'gender'=>$postData['gender'],
                'phone'=>$postData['phone'],
                'occupation'=>$postData['occupation'],
            );
            $trainee = array(
                'height'=>$postData['height'],
                'weight'=>$postData['weight'],
                'sleepStart'=>$postData['sleepStart'],
                'sleepEnd'=>$postData['sleepEnd'],
                'sportsTimePerDay'=>$postData['sportsTimePerDay'],
                'breakfast'=>$postData['breakfast'],
                'lunch'=>$postData['lunch'],
                'ifSmoke'=>$postData['ifSmoke']==0? false : true,
                'ifDrink'=>$postData['ifDrink']==0? false: true,
                'illness' =>$postData['illness'],
                'illnessDescription'=>$postData['illnessDescription'],
                'ifMedicine'=>$postData['ifMedicine']==0?false:true,
                'medicineDescription'=>$postData['medicineDescription'],
                'ifOperation'=>$postData['ifOperation']==0?false:true,
                'operationDescription'=>$postData['operationDescription']==0?false:true,
                'bodyStatus'=>$postData['bodyStatus'],
                'gymTimeOneStart'=>$postData['gymTimeOneStart'],
                'gymTimeOneEnd'=>$postData['gymTimeOneEnd'],
                'gymTimeTwoStart'=>$postData['gymTimeTwoStart'],
                'gymTimeTwoEnd'=>$postData['gymTimeTwoEnd'],
                'ifGymRoom'=>$postData["ifGymRoom"]==0?false:true,
                'toolDescription'=>$postData["toolDescription"],
                'aim'=>$postData['aim'],
                'expectation'=>$postData['expectation']
            );

            print_r($user);print_r($trainee);exit;
            if($this->registermodel->register($user)){
                printJson(array(
                   'status'=>true,
                ));
               $this->load->model("loginmodel");
               $this->loginmodel->setLogin($this->db->insert_id(),TRAINEE);
            }else{
                printJson(array(
                    'status'=>false,
                    'errorCode'=>$this->db->_error_number(),
                ));
            }


        }
        else{
            $errors = form_error();
           /* foreach($postData as $key=>$value){
               $error = form_error($key);
               if(!empty($error)){
                    $errors[$key]= $error;
                }
            }
            print_r(validation_errors());
           */
            printJson(array(
                'status'=>false,
                'errors'=>$errors,
            ));
        }

	}
    public function checkEmailDuplicate(){
        $this->load->model('registermodel');
        $email = $this->input->get('email');
        if($this->registermodel->checkDuplicate($email)){
            printJson(array(
               'status'=>true
            ));
        }else{
           printJson(array(
               'status'=>false
           ));
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */