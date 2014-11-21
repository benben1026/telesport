<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/9/14
 * Time: 6:59 PM
 */
$ACL_LIST[TRAINEE] = array(
    "Program"=>true,
    "loginTest"=>true,
    "Trainerapi"=>true,
    "Traineeapi"=>true,
    "Template"=>true,
    "Chat"=>true,
);
$ACL_LIST[TRAINER] = array(
    "Program"=>true,
    "Template"=>true,
    "Trainerapi"=>true,
    "Traineeapi"=>true,
    "Chat"=>true,
);
$ACL_LIST[ADMIN] = array(
    "Program"=>true,
    "Template"=>true,
    "LoginTest"=>true,
    "Traineeapi"=>true,
    "Trainerapi"=>true,
    "Chat"=>true,
);
$config['acl'] = $ACL_LIST;