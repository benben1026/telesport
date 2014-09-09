<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class loginTest extends Acl_Controller {

    public function index()
    {
        $email = checkLogin();
        if($email){
            $this->load->model('aclmodel');
            echo $this->aclmodel->getUserType($email);
        }else{
            echo "not logined";
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */