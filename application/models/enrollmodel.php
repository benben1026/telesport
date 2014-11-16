<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EnrollModel extends CI_Model {
	function hasQuota($programId){
		$sql = "SELECT maxNumOfUser FROM program WHERE programId=?";
		$query = $this->db->query($sql, array($programId));
		$row = $query->result_array();
		$maxNumOfUser = 0;
		if(count($row) == 1){
			$maxNumOfUser = $row[0]['maxNumOfUser'];
		}else{
			$output['status'] = false;
			$output['error'] = "SERVER_ERROR1";
			return $output;
		}
		$sql = "SELECT COUNT(*) AS num FROM enroll WHERE programId=? AND (statusId=? OR statusId=? OR statusId=? OR statusId=?)";
		$query = $this->db->query($sql, array($programId, 3,4,5,6));
		$row = $query->result_array();
		$num = 0;
		if(count($row) == 1){
			$num = $row[0]['num'];
		}else{
			$output['status'] = false;
			$output['error'] = "SERVER_ERROR2";
			return $output;
		}
		if($num < $maxNumOfUser){
			$output['status'] = true;
			$output['hasQuota'] = true;
		}else{
			$output['status'] = true;
			$output['hasQuota'] = false;
		}
		return $output;
	}

	function createPaymentCode($length = 8){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	function process($programId, $userId){
		/*
		*	1->apply for enrolling
		*	2->approve by coach, put in the waiting list
		*	3->approve by coach, wait for payment
		*	4->paid, wait for check
		*	5->payment done, wait for user to start
		*	6->user confirm to start program
		*	7->finish program
		*	8->application reject
		*	9->end program in advance
		*/
		$output = array();
		$sql = "SELECT * FROM enroll WHERE programId=? AND traineeId=?";
		$query = $this->db->query($sql, array($programId, $userId));
		$row = $query->result_array();
		if(count($row) == 0){
			$sql = "INSERT INTO enroll(statusId, paymentCode, programId, traineeId) VALUES(?, '', ?, ?)";
			$query = $this->db->query($sql, array(1, $programId, $userId));
			if($query){
				$output['status'] = true;
				$output['info'] = 'SUCCESS_APPLY_FOR_ENROLL';
			}
		}else if(count($row) == 1){
			$output['enrollId'] = $row[0]['enrollId'];
			$statusId = $row[0]['statusId'];
			switch ($statusId) {
				case 1:
					$result = $this->hasQuota($programId);
					$info;
					if(!$result['status']){
						return $result;
					}else if($result['hasQuota']){
						$paymentCode = $this->createPaymentCode();
						$sql = "UPDATE enroll SET statusId=3, paymentCode=? WHERE programId=? AND traineeId=?";
						$query = $this->db->query($sql, array($paymentCode,$programId, $userId));
						$info = "WAIT_FOR_PAYMENT";
						$output['paymentCode'] = $paymentCode;
					}else{
						$sql = "UPDATE enroll SET statusId=2 WHERE programId=? AND traineeId=?";
						$query = $this->db->query($sql, array($programId, $userId));
						$info = "WAITING_LIST";
					}
					if($query){
						$output['status'] = true;
						$output['info'] = $info;
					}else{
						$output['status'] = false;
						$output['error'] = "SERVER_ERROR";
						return $output;
					}
					break;
				case 2:
					$result = $this->hasQuota($programId);
					if(!$result['status']){
						return $result;
					}else if($result['hasQuota']){
						$paymentCode = $this->createPaymentCode();
						$sql = "UPDATE enroll SET statusId=3, paymentCode=? WHERE programId=? AND traineeId=?";
						$query = $this->db->query($sql, array($paymentCode, $programId, $userId));
						$output['status'] = true;
						$output['info'] = "WAIT_FOR_PAYMENT";
						$output['paymentCode'] = $paymentCode;
					}else{
						$output['status'] = true;
						$output['info'] = "PROGRAM_IS_FULL";
					}
					break;
				case 4:
					$output['status'] = false;
					$output['error'] = "ACCESS_DENIED";
					break;
				case 3:
				case 5:
				case 6:
					$newStatusId = $statusId + 1;
					$sql = "UPDATE enroll SET statusId=? WHERE programId=? AND traineeId=?";
					$query = $this->db->query($sql, array($newStatusId, $programId, $userId));
					if($query){
						$output['status'] = true;
					}else{
						$output['status'] = false;
						$output['error'] = "SEVER_ERROR";
					}
					break;
				case 7:
					$output['status'] = false;
					$output['info'] = "APPLICATION_REJECT";
				case 8:
				case 9:
					$sql = "UPDATE enroll SET statusId=1 WHERE programId=? AND traineeId=?";
					$query = $this->db->query($sql, array( $programId, $userId));
					if($query){
						$output['status'] = true;
					}else{
						$output['status'] = false;
						$output['error'] = "SEVER_ERROR";
					}
					break;
				default:
					$output['status'] = false;
					$output['error'] = "PROGRAM_FINISHED";
					break;
			}
		}else{
			$output['status'] = false;
			$output['error'] = "INVALID_ID";
		}
		return $output;
	}

	function getCurrentStatus($programId, $userId){
		$output = array();
		$sql = "SELECT * FROM enroll WHERE programId=? AND traineeId=?";
		$query = $this->db->query($sql, array($programId, $userId));
		$row = $query->result_array();
		if(count($row) == 1 && $row[0]['statusId'] > 0 && $row[0]['statusId'] < 10){
			$output['status'] = true;
			$output['info'] = $row[0]['statusId'];
			if($row[0]['statusId'] >= 3 && $row[0]['statusId'] != 7){
				$output['paymentCode'] = $row[0]['paymentCode'];
			}
			$output['enrollId'] = $row[0]['enrollId'];
		}else{
			$output['status'] = true;
			$output['info'] = -1;
		}
		return $output;
	}

	function exitProgram($programId, $userId){
		$output = array();
		$sql = "UPDATE enroll SET statusId=9 WHERE programId=? AND traineeId=?";
		$query = $this->db->query($sql, array($programId, $userId));
		$output['status'] = $query;
		return $output;
	}
}