<?php
$config = array(
    "register"=>array(
        array(
            'field'=>'firstName',
            'label'=>'lang:firstName',
            'rules'=>'trim|isset|min_length[2]|max_length[12]|xss_clean'
        ),
        array(
            'field'=>'lastName',
            'label'=>'lang:lastName',
            'rules'=> 'trim|isset|min_length[2]|max_length[12]|xss_clean'
        ),
        array(
            'field'=>'password',
            "label" =>'lang:password',
            'rules'=> 'trim|isset|required|matches[passConf]|min_length[6]|max_length[32]'
        ),
        array(
            'field'=>'passConf',
            'label'=> 'lang:passwordConfirmation',
            'rules'=>'trim|isset|required'
        ),
        array(
            'field'=>'email',
            'label'=> 'lang:Email',
            'rules'=>'trim|isset|required|valid_email|is_unique[user.email]|xss_clean'
        ),
        array(
            'field'=>'username',
            'label'=> 'lang:Username',
            'rules'=>'trim|required|alpha_dash|is_unique[user.username]|xss_clean'
        ),
        array(
            'field'=>"age",
            "label"=>"lang:Age",
            'rules'=>"trim|required|numeric|greater_than[0]|less_than[100]"
        ),
        array(
            'field'=>'gender',
            'label'=>'lang:Gender',
            'rules'=>'trim|isset|required|alpha_numeric|valid_gender|xss_clean'
        ),
        array(
            'field'=>'firstLanguage',
            'label'=>'lang:firstLanguage',
            'rules'=>'trim|isset|alpha|valid_language|xss_clean'
        ),
        array(
            'field'=>'secondLanguage',
            'label'=>'lang:secondLanguage',
            'rules'=>'trim|isset|alpha|valid_language|xss_clean'
        ),
        array(
            'field'=>'nationality',
            'label'=>'lang:nationality',
            'rules'=>'trim|isset|alpha|valid_nationality|xss_clean'
        ),
        array(
            'field'=>'birthday',
            'label'=>'lang:birthday',
            'rules'=>'trim|isset|xss_clean|valid_birthday'
        ),
        array(
            'field'=>"occupation",
            'label'=>"lang:occupation",
            'rules'=>'trim|isset|alpha_dash|xss_clean'
        ),
        array(
            'field'=>"phone",
            'label'=>"lang:phone",
            'rules'=>'trim|isset|alpha_dash|xss_clean|valid_phone'
        ),
        array(
            'field'=>"height",
            'label'=>"lang:height",
            'rules'=>"trim|isset|numeric|greater_than[130]|less_than[250]",
        ),
        array(
            'field'=>"weight",
            'label'=>"lang:weight",
            'rules'=>"trim|isset|numeric|greater_than[30]|less_than[250]",
        ),
        array(
            'field'=>"sleepStart",
            'label'=>"lang:sleepStart",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"sleepEnd",
            'label'=>"lang:sleepEnd",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"sportsTimePerDay",
            'label'=>"lang:sportsTimePerDay",
            'rules'=>"trim|isset|numeric|valid_sports_time_per_day"
        ),
        array(
            'field'=>"breakfast",
            'label'=>"lang:breakfastTime",
            'rules'=>"trim|isset|valid_time"
        ),
        array(
            'field'=>"lunch",
            'label'=>"lang:lunchTime",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"supper",
            'label'=>"lang:supperTime",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"ifSmoke",
            'label'=>"lang:ifSmoke",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"ifMedicine",
            'label'=>"lang:ifMedicine",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"ifOperation",
            'label'=>"lang:ifOperation",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"ifDrink",
            'label'=>"lang:ifDrink",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"operationDescription",
            'label'=>"lang:operationDescription",
            'rules'=>"trim|isset|xss_clean"
        ),
        array(
            'field'=>"medicineDescription",
            'label'=>"lang:medicineDescription",
            "rules"=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"illnessDescription",
            'label'=>"lang:illnessDescription",
            "rules"=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"illness",
            'label'=>"lang:illness",
            'rules'=>"trim|isset|xss_clean|valid_illness"
        ),
        array(
            'field'=>"aim",
            'label'=>"lang:aim",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"expectation",
            'label'=>"lang:expectation",
            'rules'=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"bodyStatus",
            'label'=>"lang:bodyStatus",
            'rules'=>"trim|isset|xss_clean|valid_body_status"
        ),
        array(
            'field'=>"gymTimeOneStart",
            'label'=>"lang:gymTimeOneStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeOneEnd",
            'label'=>"lang:gymTimeOneStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeTwoStart",
            'label'=>"lang:gymTimeTwoStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeTwoEnd",
            'label'=>"lang:gymTimeTwoStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"ifGymRoom",
            'label'=>"lang:ifGymRoom",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"toolDescription",
            'label'=>"lang:toolDescription",
            'rules'=>"trim|isset|xss_clean"
        )
    ),
    "program"=>array(
        array(
            'field'=>"name",
            'label'=>"lang:name",
            'rules'=>"trim|xss_clean|required"
        ),
        array(
            'field'=>"introduction",
            'label'=>"lang:introduction",
            'rules'=>"trim|xss_clean|required"
        ),
        array(
            'field'=>"prerequisite",
            'label'=>"lang:prerequisite",
            'rules'=>'trim|xss_clean'
        ),
        array(
            'field'=>"goal",
            "label"=>"lang:goal",
            'rules'=>"trim|xss_clean",
        ),
        array(
            'field'=>"maxNumOfUser",
            'label'=>"lang:maxNumOfUser",
            'rules'=>"trim|required|numeric|greater_than[0]|less_than[999]"
        ),
        array(
            'field'=>"duration",
            'label'=>"lang:duration",
            'rules'=>'trim|numeric|greater_than[0]|less_than[168]',
        ),
        array(
            'field'=>"templates",
            'label'=>"lang:template",
            'rules'=>"trim|xss_clean"
        ),
    ),
    'pricePlan'=>array(
        array(
            'field'=>"programId",
            'label'=>"lang:progranId",
            'rules'=>"trim|numeric"
            ),
        array(
            'field'=>"price",
            'label'=>"lang:price",
            'rules'=>"trim|numeric|required"
        ),
        array(
            'field'=>"fromDate",
            'label'=>"lang:fromDate",
            'rules'=>"trim|xss_clean|valid_date"
            ),
        array(
            'field'=>"toDate",
            'label'=>"lang:toDate",
            'rules'=>"trim|xss_clean|valid_date"
            ),
    ),
    "updateProgram"=>array(
        array(
            'field'=>"programId",
            'label'=>"lang:programId",
            'rules'=>"trim|numeric|required"
        ),
        array(
            'field'=>"templates",
            'label'=>"lang:template",
            'rules'=>"trim|xss_clean"
        ),
    ),
    "deleteProgram"=>array(
        array(
            'field'=>"programId",
            'label'=>"lang:programId",
            'rules'=>"trim|required|numeric"
        ),    
        
        
    ),
    'resetPassword' => array(
         array(
            'field'=>'password',
            "label" =>'lang:password',
            'rules'=> 'trim|isset|required|matches[passConf]|min_length[6]|max_length[32]'
        ),
        array(
            'field'=>'passConf',
            'label'=> 'lang:passwordConfirmation',
            'rules'=>'trim|isset|required'
        ),
        array(
            'field'=>'token',
            'label'=> 'lang:passwordConfirmation',
            'rules'=>'trim|isset|required'
        ),
        array(
            'field'=>'email',
            'label'=> 'lang:Email',
            'rules'=>'trim|isset|required|valid_email|is_unique[user.email]|xss_clean'
        ),
    ),
    "editUserInfo"=>array(
        array(
            'field'=>'firstName',
            'label'=>'lang:firstName',
            'rules'=>'trim|isset|min_length[2]|max_length[12]|xss_clean'
        ),
        array(
            'field'=>'lastName',
            'label'=>'lang:lastName',
            'rules'=> 'trim|isset|min_length[2]|max_length[12]|xss_clean'
        ),
        array(
            'field'=>"age",
            "label"=>"lang:Age",
            'rules'=>"trim|required|numeric|greater_than[0]|less_than[100]"
        ),
        array(
            'field'=>'gender',
            'label'=>'lang:Gender',
            'rules'=>'trim|isset|required|alpha_numeric|valid_gender|xss_clean'
        ),
        array(
            'field'=>'nationality',
            'label'=>'lang:nationality',
            'rules'=>'trim|isset|alpha|valid_nationality|xss_clean'
        ),
        array(
            'field'=>'birthday',
            'label'=>'lang:birthday',
            'rules'=>'trim|isset|xss_clean|valid_birthday'
        ),
        array(
            'field'=>"occupation",
            'label'=>"lang:occupation",
            'rules'=>'trim|isset|alpha_dash|xss_clean'
        ),
        array(
            'field'=>"phone",
            'label'=>"lang:phone",
            'rules'=>'trim|isset|alpha_dash|xss_clean|valid_phone'
        ),
        array(
            'field'=>"height",
            'label'=>"lang:height",
            'rules'=>"trim|isset|numeric|greater_than[130]|less_than[250]",
        ),
        array(
            'field'=>"weight",
            'label'=>"lang:weight",
            'rules'=>"trim|isset|numeric|greater_than[30]|less_than[250]",
        ),
        array(
            'field'=>"sleepStart",
            'label'=>"lang:sleepStart",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"sleepEnd",
            'label'=>"lang:sleepEnd",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"sportsTimePerDay",
            'label'=>"lang:sportsTimePerDay",
            'rules'=>"trim|isset|numeric|valid_sports_time_per_day"
        ),
        array(
            'field'=>"breakfast",
            'label'=>"lang:breakfastTime",
            'rules'=>"trim|isset|valid_time"
        ),
        array(
            'field'=>"lunch",
            'label'=>"lang:lunchTime",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"supper",
            'label'=>"lang:supperTime",
            'rules'=>"trim|isset|valid_time",
        ),
        array(
            'field'=>"ifSmoke",
            'label'=>"lang:ifSmoke",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"ifMedicine",
            'label'=>"lang:ifMedicine",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"ifOperation",
            'label'=>"lang:ifOperation",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"ifDrink",
            'label'=>"lang:ifDrink",
            'rules'=>"trim|isset|numeric"
        ),
        array(
            'field'=>"operationDescription",
            'label'=>"lang:operationDescription",
            'rules'=>"trim|isset|xss_clean"
        ),
        array(
            'field'=>"medicineDescription",
            'label'=>"lang:medicineDescription",
            "rules"=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"illnessDescription",
            'label'=>"lang:illnessDescription",
            "rules"=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"illness",
            'label'=>"lang:illness",
            'rules'=>"trim|isset|xss_clean|valid_illness"
        ),
        array(
            'field'=>"aim",
            'label'=>"lang:aim",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"expectation",
            'label'=>"lang:expectation",
            'rules'=>"trim|isset|xss_clean",
        ),
        array(
            'field'=>"bodyStatus",
            'label'=>"lang:bodyStatus",
            'rules'=>"trim|isset|xss_clean|valid_body_status"
        ),
        array(
            'field'=>"gymTimeOneStart",
            'label'=>"lang:gymTimeOneStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeOneEnd",
            'label'=>"lang:gymTimeOneStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeTwoStart",
            'label'=>"lang:gymTimeTwoStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"gymTimeTwoEnd",
            'label'=>"lang:gymTimeTwoStart",
            'rules'=>"trim|isset|xss_clean|valid_time"
        ),
        array(
            'field'=>"ifGymRoom",
            'label'=>"lang:ifGymRoom",
            'rules'=>"trim|isset|numeric",
        ),
        array(
            'field'=>"toolDescription",
            'label'=>"lang:toolDescription",
            'rules'=>"trim|isset|xss_clean"
        )
    ),
);