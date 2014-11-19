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
      
    }
	public function ajaxRegister(){
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
                'username'=>$postData['username'],
                //'firstName'=>$postData['firstName'],
                //'lastName'=>$postData['lastName'],
                'email'=>$postData['email'],
                'password'=>md5(md5($postData['password'])),
               // 'firstLanguage'=>$postData['firstLanguage'],
                //'secondLanguage'=>$postData['secondLanguage'],
                //'nationality'=>$postData['nationality'],
                //'birthday'=>$postData['birthday'],
                'age'=>$postData['age'],
                'balance'=>DEFAULT_BALANCE,
                'userType'=>TRAINEE,
                'rank'=>DEFAULT_RANK,
                'gender'=>$postData['gender'],
                //'phone'=>$postData['phone'],
                //'occupation'=>$postData['occupation'],
            );
            $trainee = array(
                'height'=>$postData['height'],
                'weight'=>$postData['weight'],
                //'sleepStart'=>$postData['sleepStart'],
                //'sleepEnd'=>$postData['sleepEnd'],
                'sportsTimePerDay'=>$postData['sportsTimePerDay'],
                //'breakfast'=>$postData['breakfast'],
                //'supper'=>$postData['supper'],
                'ifSmoke'=>$postData['ifSmoke']==0? false : true,
                'ifDrink'=>$postData['ifDrink']==0? false: true,
                //'illness' =>$postData['illness'],
                'illnessDescription'=>$postData['illnessDescription'],
                //'ifMedicine'=>$postData['ifMedicine']==0?false:true,
                'medicineDescription'=>$postData['medicineDescription'],
                //'ifOperation'=>$postData['ifOperation']==0?false:true,
                'operationDescription'=>$postData['operationDescription'],
                'bodyStatus'=>$postData['bodyStatus'],
                //'gymTimeOneStart'=>$postData['gymTimeOneStart'],
                //'gymTimeOneEnd'=>$postData['gymTimeOneEnd'],
                //'gymTimeTwoStart'=>$postData['gymTimeTwoStart'],
                //'gymTimeTwoEnd'=>$postData['gymTimeTwoEnd'],
                //'ifGymRoom'=>$postData["ifGymRoom"]==0?false:true,
                //'toolDescription'=>$postData["toolDescription"],
                'aim'=>$postData['aim'],
                //'expectation'=>$postData['expectation']
            );
            if($this->registermodel->register($user,$trainee)){
               
                $this->load->model("loginmodel");
                $this->loginmodel->setLogin($this->db->insert_id(),TRAINEE);
                printJson(array(
                   'status'=>true,
                ));
               
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
	public function trainerRegister(){
        $this->load->library('form_validation');
        $this->load->library("Tele_Form_validation");
        $postData = $this->input->post();

        if(empty($postData)){
            show_404();
        }
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('trainerRegister')){
            $postData = $this->input->post();
            $this->load->model('registermodel');
            $user = array(
                'username'=>$postData['username'],
                'firstName'=>$postData['firstName'],
                'lastName'=>$postData['lastName'],
                'email'=>$postData['email'],
                'password'=>md5(md5($postData['password'])),
                'firstLanguage'=>$postData['firstLanguage'],
                'secondLanguage'=>$postData['secondLanguage'],
                'nationality'=>$postData['nationality'],
                'birthday'=>$postData['birthday'],
                'age'=>$postData['age'],
                'balance'=>DEFAULT_BALANCE,
                'userType'=>TRAINER,
                'rank'=>DEFAULT_RANK,
                'gender'=>$postData['gender'],
                'phone'=>$postData['phone'],
                'occupation'=>$postData['occupation'],
                'address1'=>$postData['address']
            );
            $files = $this->do_upload(array("certificate",'passport'));
            if(!($files['certificate']['status'] &&$files['passport']['status'])){
                printJson(array(
                    'status'=>false,
                    'error'=>$files['error'],
                    'by'=>"file upload",
                    ));
                return;
            }
            $trainer = array(
               'passport_number'=>$postData['passport_number'],
               'passport'=>$files['passport']['file_info']['full_path'],
               'certificate'=>$files['certificate']['file_info']['full_path'],
               'certType'=>$postData['certType'],
                'selfIntro'=>$postData['selfIntro'],
                  'expertise'=>$postData['experise'],
            );
            if($this->registermodel->trainer($user,$trainer)){
                $this->load->model("loginmodel");
                $this->loginmodel->setLogin($this->db->insert_id(),TRAINER);
                printJson(array(
                   'status'=>true,
                ));
              
               return;
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
        if($this->registermodel->checkEmailDuplicate($email)){
            printJson(array(
               'status'=>true
            ));
        }else{
           printJson(array(
               'status'=>false
           ));
        }
    }

    public function checkUsernameDuplicate(){
        $this->load->model('registermodel');
        $username = $this->input->get('username');
        if($this->registermodel->checkUsernameDuplicate($username)){
            printJson(array(
               'status'=>true
            ));
        }else{
           printJson(array(
               'status'=>false
           ));
        }
    }
    public function resetPasswordRequest(){
        $this->load->model("usermodel");
        $this->load->helper('url');
        $email = $this->input->get('email');
        $token  = $this->usermodel->setToken(urldecode($email));
        if($token){
            $data['url'] = "http://www.promexeus.com/version0.2/zh/user/resetPassword.php?token=".$token;
            $this->usermodel->sendEmail("admin@telesports.com",$email,'申请重新设置密码',$this->load->view('mail/resetpass', $data, true));
            printJson(array(
                'status'=>true,
                'msg'=>"OK"
            ));
        }else{
            printJson(array(
                'status'=>false,
                'msg'=>"Invalid Email"
            ));
        }
    }
    public function resetPasswordView(){
        $this->load->view("resetpassword");
        
    }
    public function resetPasswordRequestView(){
        $this->load->view("resetpasswordRequest");
        
    }
    public function resetPassword(){
        $this->load->library('form_validation');
        $this->load->library("Tele_Form_validation");
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('resetPassword')){
            $this->load->model('usermodel');
            $data = $this->input->post();
            $res = $this->usermodel->resetPassword($data['email'],$data['password'],$data['token']);
            if($res>0){
                printJson(array(
                    'status'=>true,
                ));
            }
            else{
                if($res==-1){
                    printJson(array(
                        'status'=>false,
                        'err'=>'wrong email address'
                    ));
                }
                else{
                    printJson(array(
                        'status'=>false,
                        'err'=>'wrong token or email'
                    ));
                }
            }
        }else{
            $errors = form_error();
            printJson(array(
                'status'=>false,
                'err'=>$errors,
            ));
        }
    }
    private function do_upload($fileNames = array())
	{
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;

		$this->load->library('upload', $config);
        $result = array();
        foreach($fileNames as $file){
    		if ( ! $this->upload->do_upload($file))
    		{
    			$result[$file] = array(
    			    'status'=>false,
    			    );
    			$result['error'] = $this->upload->display_errors();
    		}
    		else
    		{
    			$data = array('upload_data' => $this->upload->data());
    			$result[$file] = array(
    			    'status'=>true,
    			    'file_info'=>$this->upload->data()
    			);
    		}
        }
        return $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */