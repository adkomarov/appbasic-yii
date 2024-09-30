<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['specialsection'],//'takedatam'
    //'bootstrap5' => ['takedatam'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@app' => '/work/sites/yiiprojects/appbasic/basic',
    ],
    'components' => [
        'assetManager' => [
            //$sourcePath='@module_specialsection_root';
            'linkAssets' => False,//true,
            //'sourcePath' => '@app/modules/specialsection/public',
            'forceCopy' => True,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gqsfyaths0Aiv2_rGdNBmx53gWVp1Ujv',
            'enableCsrfValidation' => true,
            'enableCookieValidation'=>true,
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        
        //необходимо чтобы ссылки совпали с редиректами
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /*
                'form'=>'takedatam/default/savedataview',
                'read'=>'takedatam',
                'form1'=>'takedatam/default/index',
                'form2'=>'takedatam/default/form2',
                'form3'=>'takedatam/default/form3',
                'form4'=>'takedatam/default/form4',
                'document' => 'takedatam/default/document',
                'paidedu' => 'takedatam/default/paidedu',
                'grants' => 'takedatam/default/grants',
                'testmodule1' => 'testmodule/<controller>/<action>'
                */
                /*
                '/form1'                                                   => 'takedatam/default/index',
                '/form2'                                                   => 'takedatam/default/form2',
                '/form3'                                                   => 'takedatam/default/form3',
                '/form4'                                                   => 'takedatam/default/form4',
                '/paid_edu'                                                => 'takedatam/default/paidedu',
                '/grantsold'                                               => 'takedatam/default/grantsold',
                '/grants'                                                  => 'takedatam/default/grants',
                '/document'                                                => 'takedatam/default/document',
                '/common'                                                  => 'takedatam/default/common',
                '/eduStandarts'                                            => 'takedatam/default/edustandarts',
                '/inter'                                                   => 'takedatam/default/inter',
                '/upload'                                                  => 'takedatam/default/upload',
                '/deleteform2'                                             => 'takedatam/default/deleteform2',
                '/deleteform3'                                             => 'takedatam/default/deleteform3',
                '/deleteform4'                                             => 'takedatam/default/deleteform4',
                '/delete_paid_edu'                                         => 'takedatam/default/deletepaidedu',
                '/delete_grants'                                           => 'takedatam/default/deletegrants',
                '/delete_document'                                         => 'takedatam/default/deletedocument',
                '/delete_inter'                                            => 'takedatam/default/deleteinter',
                */
            ],
        ],
        
    ],
    'modules' => [
        'testmodule' => [
            'class' => 'app\modules\testmodule\Module',
        ],
        //'takedatam' => [
        //    'class' => 'app\modules\takedatam\Module',
        //],
        'specialsection' => [
            'class' => 'app\modules\specialsection\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::'],
    ];
}

return $config;
