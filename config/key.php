<?php

//各种第三方的key 和 secret

return [
    //阿里大于 短信
    'alidayu'=>[
        'app_key'=>env('ALIDAYU_APP_KEY', null),
        'app_secret'=>env('ALIDAYU_APP_SECRET', null),
        'sign_name'=>reEnv('ALIDAYU_SIGN_NAME', null),
        'template_code'=>reEnv('ALIDAYU_TEMPLATE_CODE', null),
        'project_name'=>reEnv('ALIDAYU_PROJECT_NAME', null),
    ]




];