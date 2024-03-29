<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends Acl_Ajax_Controller {
    function index(){
        $postData = $this->input->post();
        $this->load->model("chatmodel");
        $read = array();
        $send = array();
        $get = array();
        $fromUser = $this->user['id'];
        if(isset($postData['readMsg'])){
            $read = $this->chatmodel->setReadMsg($postData['readMsg']);
        }
        if(isset($postData['sendMsg'], $fromUser, $postData['toUser'], $postData['enrollId'])){
            $temp = json_decode($postData['sendMsg'], TRUE);
            if(!empty($temp)){
                $send = $this->chatmodel->sendMsg($fromUser, $postData['toUser'], $temp['content'], $temp['type'], $postData['enrollId']);
            }
        }
        if(isset($fromUser, $postData['toUser'], $postData['enrollId'])){
            $get = $this->chatmodel->getMsg($fromUser, $postData['toUser'], $postData['enrollId']);
        }
        $output = array();
        $output['SETREADMSG'] = $read;
        $output['NEWMSG'] = $get;
        $output['SENDMSG'] = $send;
        $this->output($output);
        
    }
    
    function getHistory($enrollId, $messageId, $offset){
        if(!is_numeric($enrollId) || !is_numeric($messageId) || !is_numeric($offset)){
            printJson(array(
                'status'=>false,
                'error'=>'INVALID_ID',
            ));
            return;
        }
        $userId = $this->user['id'];
        $this->load->model("chatmodel");
        printJson($this->chatmodel->getHistory($userId, $enrollId, $messageId, $offset));
    }
    
    function output($res){
        printJson($res);
    }
}

