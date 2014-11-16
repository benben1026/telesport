<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
    public function index(){
      
    }
    public function program(){
        $postData = $this->input->post();
        $valid_search_key = array("goal","name","duration","language","traineerName");
    }
    
}