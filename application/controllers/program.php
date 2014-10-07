
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Login extends Acl_Ajax_Controller {
    public function index(){

    }
    public function createProgram(){
        $this->load->library('form_validation');
        $this->load->library("Tele_Form_validation");
        $postData = $this->input->post();

        if(empty($postData)){
            show_404();
        }
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');


    }

}