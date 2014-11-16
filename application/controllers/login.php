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
            if(!isset($postData['rememberMe'])){
                $postData['rememberMe'] = false;
            }
            //echo("Hello World");
            //echo("parameter=".$postData['cookie']);
            
            if(isset($postData['cookie'])){
                $this->autoLogin($postData['userId'], $postData['cookie']);
            }else{
                $this->checkLogin($postData['email'], $postData['password'], $postData['rememberMe']);
            }
             
	}
        
        public function autoLogin($userId, $cookie){
            if($this->loginmodel->autoLogin($userId, $cookie)){
                $output = array(
                            'AUTO_LOGIN'=>TRUE
                        );
                $this->output($output);
            }else{
                $output = array(
                            'AUTO_LOGIN'=>FALSE
                        );
                $this->output($output);
            }
        }
        
        public function checkLogin($email, $password, $rememberMe){
            $res = $this->loginmodel->checkLogin($email, $password);
            if( $res['status'] ){
                if($rememberMe == 1){
                    if($this->loginmodel->rememberme($email) == 1){
                        $output = array(
                            'LOGIN'=>TRUE,
                            'REMEMBER'=>TRUE,
                            'userName'=>$res['userName'],
                            'userType'=>$res['userType'],
                            'userId'=>$res['userId']
                        );
                        $this->output($output);
                        return;
                    }
                }
                $output = array(
                            'LOGIN'=>TRUE,
                            'REMEMBER'=>FALSE,
                            'userName'=>$res['userName'],
                            'userType'=>$res['userType'],
                            'userId'=>$res['userId']
                        );
                $this->output($output);
            }else if($res['code'] == -2){
                $output = array(
                            'LOGIN'=>FALSE,
                            'ERROR'=>'NOT_VARIFIED',
                            'REMEMBER'=>FALSE
                        );
                $this->output($output);
            }else{
                $output = array(
                            'LOGIN'=>FALSE,
                            'ERROR'=>'MISMATCH',
                            'REMEMBER'=>FALSE
                        );
                $this->output($output);
            }
        }
        
        function output($res){
            printJson($res);
        }
        
        public function getUserName(){
            $id  = isLogin();
            if($id){
                $this->load->model("usermodel");
                $user = $this->usermodel->getUserInfoById($id);
                printJson(array(
                    "status"=>true,
                    "name"=>$user['username'],
                    ));
            }else{
                printJson(array(
                    "status"=>false,
                    ));
            }
        }
        public function getUserType(){
            $id  = isLogin();
            if($id){
                $this->load->model("usermodel");
                $user = $this->usermodel->getUserInfoById($id);
                printJson(array(
                    "status"=>true,
                    "name"=>$user['username'],
<<<<<<< HEAD
                    'type'=>$user['userType'],
                    'id'=>$id
=======
                    'type'=>$user['userType']
>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
                    ));
            }else{
                printJson(array(
                    "status"=>false,
                    ));
            }
        }
        public function logout(){
            $this->load->model("loginmodel");
            $this->loginmodel->logout();
        }
<<<<<<< HEAD
        public function changePassword(){
            $this->load->model("usermodel");
            $postData = $this->input->post();
            $email = $postData['email'];
            $prepwd = $postData['prepwd'];
            $newpwd = $postData['newpwd'];
            $pwdconf = $postData['pwdconf'];
            $res = $this->usermodel->changePassword($email, $prepwd, $newpwd, $pwdconf);
            printJson($res);
        }
=======
>>>>>>> e36010547fdd7d9de9e9602b04d034292d6f3589
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */