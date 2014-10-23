<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_Controller extends CI_Controller {
    protected $user = array();
    function __construct()
    {
        parent::__construct();
        $this->user['id'] = isLogin();

        if($this->user['id']){
            $this->user['type']= $this->session->userdata('userType');
            $acl = $this->config->item('acl');
            $this->load->model('aclmodel');
          
            if(!isset($acl[ $this->user['type']][get_class($this)]) || !$acl[$this->user['type']][get_class($this)]){
                show_404();
            }
        }else{
           show_404();
        }
    }
}
class Acl_Ajax_Controller extends CI_Controller {
    protected $user = array();
    function __construct()
    {
        parent::__construct();
        $this->user['id'] = isLogin();

        if($this->user['id']){
            $this->user['type']= $this->session->userdata('userType');
            $acl = $this->config->item('acl');
            $this->load->model('aclmodel');
          
            if(!isset($acl[ $this->user['type']][get_class($this)]) || !$acl[$this->user['type']][get_class($this)]){
                printJson(array(
                    'status'=>false,
                    'error'=>"You don't have privilige to access this"
                ));
            }
        }else{
            printJson(array(
                'status'=>false,
                'error'=>"Please login"
            ));
            exit;
        }
    }
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */