<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tele_Form_validation extends CI_Form_validation
{
    private $ci;

    function __construct($rules = array())
    {
        parent::__construct($rules);
        $this->ci = &get_instance();
        $this->ci->load->config("formconstant");
    }
    function valid_sports_time_per_day($option){
        return in_array($option,array_keys($this->ci->config->item("formConstant")["sportsPerDay"]));
        //return false;
    }
    function valid_language($lang){
        return true;
    }
    function valid_nationality($nation){
        return true;
    }
    function valid_gender($gender){
        if($gender==0||$gender==1)
            return true;
        else
            return false;
    }
    function valid_birthday($birthday){
        return preg_match("/^\d{4}(-\d{2}){2}$/",$birthday)>0?true:false;
    }
    function valid_time($time){
        return preg_match("/^\d{2}(:\d{2}){1,2}$/",$time)>0?true:false;
    }
    function valid_phone(){
        return true;
    }
//...add more rules
}