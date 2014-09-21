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
    function valid_aim($option){
        return in_array($option,array_keys($this->ci->config->item("formConstant")["aim"]));
    }
    function valid_illness($option){
        return in_array($option,array_keys($this->ci->config->item("formConstant")["illness"]));
    }
    function valid_body_status($option){
        return in_array($option,array_keys($this->ci->config->item("formConstant")["bodyStatus"]));
    }
    function valid_language($lang){
        return true;
    }
    function valid_nationality($nation){
        return true;
    }
    function valid_gender($gender){
        return preg_match("/^[01]{1}$/",$gender)>0?true:false;
    }
    function valid_birthday($birthday){
        return preg_match("/^(19[0-9]{2}|20[0-9]{2})-(0[0-9]|1[12])-([01][0-9]|2[0-4])$/",$birthday)>0?true:false;
    }
    function valid_date($date){
        return preg_match("/^(19[0-9]{2}|20[0-9]{2})-(0[0-9]|1[12])-([01][0-9]|2[0-4])$/",$date)>0?true:false;
    }
    function valid_time($time){
        return preg_match("/^\d{2}(:\d{2}){1,2}$/",$time)>0?true:false;
    }
    function valid_phone($phone){
        return preg_match("/^1[354][0-9]\d{8}$/",$phone)>0?true:false;
    }
//...add more rules
}