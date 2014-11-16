<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enroll extends CI_Controller{
	function index(){
		$postData = $this->input->post();
		if(!isset($postData['programId'], $postData['traineeId'])){
			$output = array();
			$output['status'] = false;
			$output['error'] = 'INVALID_PARAMETER';
			$this->output($output);
			return;
		}
		$this->load->model("enrollmodel");
		//echo "test" . $postData['type'] . $postData['type']) == 1;
		
		if($postData['type'] == 1){
			$this->process($postData['programId'], $postData['traineeId']);
		}else if($postData['type'] == 2){
			$this->getStatus($postData['programId'], $postData['traineeId']);
		}else if($postData['type'] == 3){
			$this->exitProgram($postData['programId'], $postData['traineeId']);
		}
		
	}

	function process($programId, $userId){
		$this->output($this->enrollmodel->process($programId, $userId));
	}

	function getStatus($programId, $userId){
		$this->output($this->enrollmodel->getCurrentStatus($programId, $userId));
	}

	function exitProgram($programId, $userId){
		$this->output($this->enrollmodel->exitProgram($programId, $userId));
	}

	function output($res){
        printJson($res);
    }
}