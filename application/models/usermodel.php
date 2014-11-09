<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/5/14
 * Time: 10:56 PM
 */

class UserModel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function getUserInfoById($id){
        $sql = "SELECT username,gender,userType,age,height,weight,aim,sportsTimePerDay,ifSmoke,ifDrink,
        illness,illnessDescription,medicineDescription,
        operationDescription,bodyStatus,firstName,lastName,nationality,firstLanguage,
        secondLanguage,phone,occupation,address1,address2,address3 
         FROM user LEFT JOIN trainee ON 
         user.userId = trainee.userId  WHERE user.userId = ?";
        $query = $this->db->query($sql,array((int)$id));
        
        return $query->row_array();
    }
    function updateTraineeInfo($user,$trainee){
        $id = $user['id'];
        unset($user['id']);
      
        $this->db->where("userId",(int)$id);
        $this->db->update("user",$user);
        $this->db->where("userId",(int)$id);
        $this->db->update("trainee",$trainee);
        return $this->db->affected_rows();
    }
    function setToken($email){
        $this->load->helper("stringext");
        $token = generateToken();
        $update = array(
                "token"=>$token,
            );
        $this->db->where("email",$email);
        $this->db->update("user",$update);
        
        if($this->db->affected_rows()!=0){
            return $token;
        }else{
            return false;
        }
    }
    function sendEmail($fromEmail,$toEmail,$subject,$content){
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($fromEmail, 'Bruce');
        $this->email->to($toEmail); 
        $this->email->subject($subject);
        $this->email->message($content);	
        $this->email->send();
    }
    function resetPassword($email,$token,$password){
        $this->db->where("email",$email);
        $this->db->where("token",$token);
        $this->db->update("user",md5(md5($password)));
        return $this->db->affected_rows();
    }
    function getTrainerInfo($data,$id){
        $select = join($data,',');
        $sql = "SELECT $select
         FROM user LEFT JOIN trainer ON 
         user.userId = trainer.userId  WHERE user.userId = ? and userType =".TRAINER;
        $query = $this->db->query($sql,array((int)$id));
         return $query->row_array();
    }
}