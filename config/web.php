<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'category/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'AndreyShonin',
            'baseUrl' => '',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'advanced/<col:\d+>/<spo:\d+>/<gen:\d+>/<brand:\d+>/<size:\d+>/<type:\d+>/<byprice:\d+>/<product_type>/page/<page:\d>' => 'category/advanced',
                'advanced/<col:\d+>/<spo:\d+>/<gen:\d+>/<brand:\d+>/<size:\d+>/<type:\d+>/<byprice:\d+>/<product_type>' => 'category/advanced',
                'category/<col:\d+>/<spo:\d+>/<gen:\d+>/<brand:\d+>/<size:\d+>/<type:\d+>/<byprice:\d+>/<product_type>/page/<page:\d>' => 'category/view',
                'category/<col:\d+>/<spo:\d+>/<gen:\d+>/<brand:\d+>/<size:\d+>/<type:\d+>/<byprice:\d+>/<product_type>' => 'category/view',
                'search' => 'category/search',
                'product/<id:\d+>' => 'product/view',
                'register' => 'site/register',
                'login' => 'site/login',

            ],
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
