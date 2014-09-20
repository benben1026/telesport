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
        $this->user['id'] = checkLogin();
        $acl = $this->config->item('acl');
        $this->load->model('aclmodel');
        $userType = $this->aclmodel->getUserType($this->user);
        if(!isset($acl[$userType][get_class($this)]) || !$acl[$userType][get_class($this)]){
            show_404();
        }else{
            echo "SUCCESS";
        }
    }
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */