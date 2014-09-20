<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_Controller extends CI_Controller {
    protected $user;
    function __construct()
    {
        parent::__construct();
        $user = checkLogin();

        $acl = $this->config->item('acl');
        if(!isset($acl[get_class($this)]) || !$acl[get_class($this)]){
            show_404();
        }
    }
}
class Acl_Ajax_Controller extends CI_Controller {
    protected $user;
    function __construct()
    {
        parent::__construct();
        $this->user['id'] = isLogin();

        if($this->user['id']){
            $this->user['type']= $this->session->userdata('userType');
            $acl = $this->config->item('acl');
            $this->load->model('aclmodel');

            if(!isset($acl[ $this->user['type']][get_class($this)]) || !$acl[ $this->user['type']][get_class($this)]){
                show_404();
            }else{
                echo "SUCCESS";
            }
        }else{
            show_404();
        }
    }
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */