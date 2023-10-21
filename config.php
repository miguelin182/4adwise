<?php
return [
    /* Database access */
    'database' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'adwiseco_herramientas',
        'username'  => 'adwiseco_becerra',
        'password'  => '@Becerra2020',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],

    /* Session configuration */
    'session-time' => 10, // hours
    'session-name' => 'application-auth',

    /* Secret key */
    'secret-key' => '@asd9ws.w6*',

    /* Environment */
    'environment' => 'dev', // Options: dev, prod, stop

    /* Timezone */
    'timezone' => 'America/Hermosillo',

    /* Cache */
    'cache' => false,

    //COMPANI NAME
    'company_name'=>'4Adwise',
    'company_addres'=>'',
    'company_phone'=>'',
    'company_email'=>'',

    'emailconfig'=>[
        'user'=>'no-reply@4adwise.com',
        'password'=>'@4adwise2021!',
        'host'=>'mail.4adwise.com',
        'port'=>465
    ]
];