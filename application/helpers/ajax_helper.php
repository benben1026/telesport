<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/9/14
 * Time: 3:18 PM
 */
if ( ! function_exists('printJs')){
    function printJson($data){
        $ci  =& get_instance();
        $ci->output->set_header("Content-Type:application/json;charset=utf-8");
        print_r(json_encode($data));
    }
}