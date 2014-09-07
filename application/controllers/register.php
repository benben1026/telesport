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
        $this->ajaxRegister();
    }
	public function ajaxRegister()
	{
        $this->load->library('form_validation');
        $postData = $this->input->post();
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_rules('firstName', 'lang:firstName', 'trim|required|min_length[2]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('lastName', 'lang:lastName', 'trim|required|min_length[2]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|matches[passConf]|md5');
        $this->form_validation->set_rules('passConf', 'lang:passwordConfirmation', 'trim|required');
        $this->form_validation->set_rules('email', 'lang:Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('firstLanguage', 'lang:firstLanguage', 'trim|required:xss_clean|callback_valid_language');
        $this->form_validation->set_rules('secondLanguage', 'lang:firstLanguage', 'trim|required:xss_clean|callback_valid_language');
        if($this->form_validation->run()){

        }
        else{
            echo form_error('password');
        }

	}
    public function valid_language($lang){
        return false;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */