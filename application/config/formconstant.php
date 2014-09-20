<?php

 $formConstant['sportsPerDay'] = array(
     1=>array(
         "sc"=>"少于10分钟",
         'en'=>"less than 10 minutes",
     ),
     2=>array(
         'sc'=>"10分钟--30分钟",
         'en'=>"10 minutes to 30 minutes",
     ),
     3=>array(
         "sc"=>"30分钟--1小时",
         'en'=>"30 minutes to 1 hour",
     ),
     4=>array(
         "sc"=>"1小时--2小时",
         "en"=>"1 hour to 2 hours",
     ),
     5=>array(
         "sc"=>"2小时以上",
         "en"=>"more  than 2 hours",
     ),
 );
/*@TODO Add more option*/;
$formConstant['illness'] = array(
    1=>array(
        "sc"=>"心脏疾病",
        "en"=>""
    ),
    2=>array(
        "sc"=>"呼吸道疾病",
        "en"=>""
    ),
);
$formConstant['bodyStatus'] = array(
    1=>array(
        "sc"=>"心悸和心动过速",
        "en"=>"心悸和心动过速"
    ),
    2=>array(
        "sc"=>"间歇性跛行",
        'en'=>"间歇性跛行"
    ),
);
$formConstant['aim'] = array(
    1=>array(
        "sc"=>"增肌塑形",
        'en'=>"增肌塑形",
    ),
    2=>array(
        "sc"=>"减肥瘦身",
        "en"=>"减肥瘦身",
    ),
    3=>array(
        "sc"=>"减压排毒",
        "en"=>"减压排毒",
    ),
    4=>array(
        "sc"=>"提升速度力量",
        "en"=>"提升速度力量",
    ),
    5=>array(
        "sc"=>"提升心肺功能",
        "en"=>"提升心肺功能"
    ),
);
$config['formConstant'] = $formConstant;