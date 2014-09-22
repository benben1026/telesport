
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
        //$postData = $this->input->post();
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');

    }

}