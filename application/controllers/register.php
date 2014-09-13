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
        $postData = $this->input->post();
        if(empty($postData)){
            show_404();
        }
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');
        $this->form_validation->set_rules('firstName', 'lang:firstName', 'trim|required|min_length[2]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('lastName', 'lang:lastName', 'trim|required|min_length[2]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|matches[passConf]|md5');
        $this->form_validation->set_rules('passConf', 'lang:passwordConfirmation', 'trim|required');
        $this->form_validation->set_rules('email', 'lang:Email', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('gender', 'lang:Gender', 'trim|required|numeric|callback_valid_gender');
        $this->form_validation->set_rules('firstLanguage', 'lang:firstLanguage', 'trim|required|callback_valid_language|xss_clean');
        $this->form_validation->set_rules('secondLanguage', 'lang:secondLanguage', 'trim|required|callback_valid_language|xss_clean');
        $this->form_validation->set_rules('nationality', 'lang:nationality', 'trim|required|callback_valid_nationality|xss_clean');
        $this->form_validation->set_rules('birthday', 'lang:birthday', 'trim|required|xss_clean');
        if($this->form_validation->run()){

            $this->load->model('registermodel');
            $data = array(
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
            );

            if($this->registermodel->register($data)){
                printJson(array(
                   'status'=>true,
                ));
                $this->session->set_userdata(array(
                    "email"=>$postData['email'],
                    "isLogin"=>true
                ));
            }else{
                printJson(array(
                    'status'=>false,
                    'errorCode'=>$this->db->_error_number(),
                ));
            }


        }
        else{
            $errors = array();
            foreach($postData as $key=>$value){
               $error = form_error($key);
               if(!empty($error)){
                    $errors[$key]= $error;
                }
            }
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
    function valid_language($lang){
        return true;
    }
    function valid_nationality($nation){
        return true;
    }
    function valid_gender($gender){
        if($gender==0||$gender==1)
            return true;
        else
            return false;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */