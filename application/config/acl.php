<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 9/9/14
 * Time: 6:59 PM
 */
$ACL_LIST[TRAINEE] = array(
    "Program"=>false,
    "loginTest"=>true,
);
$ACL_LIST[TRAINER] = array(
    "Program"=>true,
    "Template"=>true,
);
$ACL_LIST[ADMIN] = array(
    "Program"=>true,
    "Template"=>true,
    "LoginTest"=>true,
);
$config['acl'] = $ACL_LIST;