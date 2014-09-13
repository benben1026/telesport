<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
            $this->load->model("loginmodel");
            $postData = $this->input->post();
            if(isset($postData['autoLogin'])){
                autoLogin($postData['userId'], $postData['cookie']);
            }else{
                checkLogin($postData['email'], $postData['password'], $postData['rememberMe']);
            }
	}
        
        public function autoLogin($userId, $cookie){
            if($this->loginmodel->autoLogin($userId, $cookie)){
                output(true);
            }else{
                output(false);
            }
        }
        
        public function checkLogin($email, $password, $rememberMe){
            if($this->loginmodel->checkLogin($email, $password)){
                if($rememberMe == 1){
                    $this->loginmodel->rememberme($email);
                }
                output(true);
            }else{
                output(false);
            }
        }
        
        public function output($res){
            $output = array(
                    'result'=>$res
                );
            echo json_encode($output);
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */