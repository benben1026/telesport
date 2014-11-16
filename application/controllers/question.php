<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Question extends CI_Controller {

    public function index(){
    }

    public function postQuestion(){
    	$this->load->library('form_validation');
        if(empty($postData)){
            show_404();
        }
        $this->form_validation->set_language("chinese");
        $this->form_validation->set_error_delimiters('','');

    	$this->load->model("questionmodel");
        $postData = $this->input->post(); 	
 		$question = array(
            'userId'=>$postData['userId'],
            'content'=>$postData['content'],
            );
 		if($this->questionmodel->postQuestion($question)){
 		    printJson(array(
 		       'status'=>true,
 		    ));
 		}else{
 		    printJson(array(
 		        'status'=>false,
 		        'errorCode'=>$this->db->_error_number(),
 		    ));
 		}
    }
}