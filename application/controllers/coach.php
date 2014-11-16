<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coach extends CI_Controller {
    function index(){
        
    }
    
    function getCoachList(){
        $postData = $this->input->post();
        $this->load->model("coachmodel");
        printJson($this->coachmodel->getCoachList());
    }
    
    function output($res){
        printJson($res);
    }
}
