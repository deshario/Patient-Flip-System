<?php
use kartik\mpdf\Pdf;
use \kartik\datecontrol\Module;
$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$config = [
    'id' => 'basic',
    'name' => 'Patient Monitoring System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'patient',
    'modules' => [
      'displayTimezone' => 'UTC', // set your display timezone
      'saveTimezone' => 'UTC',
       'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],

        'datecontrol' =>  [
           'class' => 'kartik\datecontrol\Module',
           'displayTimezone' => 'UTC', // set your display timezone
           'saveTimezone' => 'UTC',
   ],
    ],
    'timeZone' => 'Asia/Bangkok',
    'components' => [
      'formatter' => [
       'class' => 'yii\i18n\Formatter',
       'dateFormat' => 'php:j M Y',
       'datetimeFormat' => 'php:j M Y H:i',
       'timeFormat' => 'php:H:i',
       'timeZone' => 'Asia/Bangkok',
   ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte'
                ],
            ],
        ],
      'urlManager' => [
           'class' => 'yii\web\UrlManager',
           'showScriptName' => false,
           'enablePrettyUrl' => true,
           'rules' => [
//              'patient' => 'patient/index',
//              'patient++' => 'patient/create',
//              'records' => 'turning/index',
//              'records++' => 'turning/create',
//              'staff' => 'staff/index',
//              'staffs' => 'staff/create',
           ]
        ],
        // 'pdf' => [
        //      'class' => Pdf::classname(),
        //      'format' => Pdf::FORMAT_A4,
        //      'orientation' => Pdf::ORIENT_PORTRAIT,
        //      'destination' => Pdf::DEST_BROWSER,
        //  ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'LKWI5FDr78tKyx_4ZcYzc-XlUCcUTV5C',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     //'allowedIPs' => ['127.0.0.1', '::1'],
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
