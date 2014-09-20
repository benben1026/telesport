<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/9/14
 * Time: 6:59 PM
 */
$ACL_LIST[TRAINEE] = array(
    "AdminController"=>false,
    "TrainerController"=>false,
    "TraineeController"=>true,
    "loginTest"=>false,
);
$ACL_LIST[TRAINER] = array(
    "AdminController"=>false,
    "TrainerController"=>true,
    "TraineeController"=>false,
);
$ACL_LIST[ADMIN] = array(
    "AdminController"=>true,
    "TrainerController"=>true,
    "TraineeController"=>true,
);
$config['acl'] = $ACL_LIST;