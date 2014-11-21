<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/21/14
 * Time: 12:52 PM
 */

class Question extends CI_Controller {

    public function index(){
    	echo "test";
    }

    public function postQuestion(){
    	echo "hello";
        $postData = $this->input->post(); 	  	

        if(empty($postData)){
            show_404();
        }

    	$this->load->model("questionmodel");

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