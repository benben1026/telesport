<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $acl = $this->config->item('acl');
        if(!isset($acl[get_class($this)]) || !$acl[get_class($this)]){
            show_404();
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */