<?php

$params = include __DIR__ . '/params.php'; //$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'dyntech',
    'name' => 'RotorDYN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'K0I9yOJPLBqbaam4IWrqtelfxp1m1zEXB04f5H6D',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
	        'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // 'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            // 'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'dyntech@dyntechnologies.com.br',
                'password' => 'main_dyntech@280910',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false ] ]
            ]
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
            'enableStrictParsing' => true,
            'rules' => [
                //'utility' => 'utility/default/index',
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'notifications/notifications',
                    'pluralize'     => false,
                     'tokens' => [
                        '{id}'      => '<id:\w+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}'         => 'options',
                        'OPTIONS getNotification/{id}'     => 'options',
                        'GET index' => 'index',
                        'GET poll' => 'poll',
                        'GET read' => 'read',
                        'GET {id}' => 'getNotification',
                    ],
                ],
                'ping'  =>  'site/ping',
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/payment',
                    'pluralize'     => false,
                    'tokens' => [
                        '{id}'      => '<id:\w+>',
                        '{userId}'  => '<userId:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}'         => 'options',
                        'OPTIONS balance/{userId}'     => 'options',
                        'GET index'            => 'index',
                        'GET {id}'         => 'view',
                        'GET balance/{userId}' => 'balance',
                    ],
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/project',
                    'pluralize'     => false,
                    'tokens' => [
                        '{id}'      => '<id:\w+>',
                        '{userId}'  => '<userId:\d+>',
                        '{unit}'    => '<unit:\w+>',
                        '{name}'    => '<name:\w+>',
                        '{jid}'     => '<jid:\w+>',
                        '{cid}'     => '<cid:\w+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}'       => 'options',
                        'OPTIONS {id}/{name}'=> 'options',
                        'GET index {userId}' => 'index',
                        'GET view {unit}'    => 'view',
                        'GET {id}/{name}'    => 'chart',
                        'PUT {id}/{unit}'    => 'update',
                        'POST {jid}/journal' => 'set-journal',
                        'GET report'   => 'report',
                    ],
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/machine',
                    'pluralize'     => false,
                    'tokens' => [
                        '{id}'             => '<id:\w+>',
                        '{runid}'          => '<runid:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}'       => 'options',
                        'GET execute'        => 'execute',
                        'OPTIONS execute'    => 'options',
                        'GET change'         => 'change',
                        'OPTIONS change'     => 'options',
                        'POST log'           => 'log',
                        'OPTIONS log'        => 'options',
                        'GET status'         => 'status',
                        'OPTIONS status'     => 'options',
                    ],
                ],
                [
	                'class'         => 'yii\rest\UrlRule',
	                'controller'    => 'v1/user',
	                'pluralize'     => false,
	                'tokens' => [
		                '{id}'             => '<id:\d+>',
	                ],
	                'extraPatterns' => [
		                'OPTIONS {id}'      =>  'options',
		                'POST login'        =>  'login',
		                'OPTIONS login'     =>  'options',
		                'POST signup'       =>  'signup',
		                'OPTIONS signup'    =>  'options',
		                'POST confirm'      =>  'confirm',
		                'OPTIONS confirm'   =>  'options',
		                'POST password-reset-request'       =>  'password-reset-request',
		                'OPTIONS password-reset-request'    =>  'options',
		                'POST password-reset-token-verification'       =>  'password-reset-token-verification',
		                'OPTIONS password-reset-token-verification'    =>  'options',
		                'POST password-reset'       =>  'password-reset',
		                'OPTIONS password-reset'    =>  'options',
                        'POST contact'       =>  'contact',
                        'OPTIONS contact'    =>  'options',
                        'POST create-ticket'       =>  'create-ticket',
                        'OPTIONS create-ticket'    =>  'options',
		                'GET me'            =>  'me',
		                'POST me'           =>  'me-update',
		                'OPTIONS me'        =>  'options',
	                ]
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/staff',
                    'pluralize'     => false,
                    'tokens' => [
                        '{id}'             => '<id:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}'              =>  'options',
                        'POST login'                =>  'login',
                        'OPTIONS login'             =>  'options',
                        'GET get-permissions'       =>  'get-permissions',
                        'OPTIONS get-permissions'   =>  'options',
                    ]
                ],
                [
                    'class'         => 'yii\rest\UrlRule',
                    'controller'    => 'v1/setting',
                    'pluralize'     => false,
                    'tokens'        => [
                        '{id}'             => '<id:\d+>',
                    ],
                    'extraPatterns' => [
                        'GET public'        =>  'public',
                        'OPTIONS public'    =>  'options',
                        'GET me'            =>  'me',
                        'POST me'           =>  'me-update',
                        'OPTIONS me'        =>  'options',
                    ]
                ],
                [
	                'class'         => 'yii\rest\UrlRule',
	                'controller'    => 'v1/page',
	                'pluralize'     => false,
	                'tokens'        => [
                        '{runId}'           => '<id:\d+>',
	                ],
	                'extraPatterns' => [
                        'OPTIONS log {runId}'  =>  'options',
                        'GET sse'       =>  'sse',
                        'OPTIONS sse'    =>  'sse',
                        'GET log'        => 'log',
	                ]
                ],
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {

                $response = $event->sender;
                if($response->format == 'html') {
                    return $response;
                }

                $responseData = $response->data;

                if(is_string($responseData) && json_decode($responseData)) {
                    $responseData = json_decode($responseData, true);
                }


                if($response->statusCode >= 200 && $response->statusCode <= 299) {
                    $response->data = [
                        'success'   => true,
                        'status'    => $response->statusCode,
                        'data'      => $responseData,
                    ];
                } else {
                    $response->data = [
                        'success'   => false,
                        'status'    => $response->statusCode,
                        'data'      => $responseData,
                    ];

                }
                return $response;
            },
        ],
        'sse' => [
	        'class' => \odannyc\Yii2SSE\LibSSE::class
        ],
        'converter' => [
            'class' => 'app\components\Converter',
            'system' => 'si',
            'ratio' => 1000,
        ]

    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
        'notifications' => [
            'class' => 'machour\yii2\notifications\NotificationsModule',
            // Point this to your own Notification class
            // See the "Declaring your notifications" section below
            'notificationClass' => 'app\components\Notification',
            // Allow to have notification with same (userId, key, keyId)
            // Default to FALSE
            'allowDuplicate' => false,
            // This callable should return your logged in user Id
            'userId' => function() {
                return 1; //\Yii::$app->user->identity->id;
            },
            'userGroup' => function() {
                return 99; //\Yii::$app->user->identity->role;
            },
        ],
        /*'utility' => [
            'class' => 'c006\utility\migration\Module',
        ],*/
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    /*$config['bootstrap'][] = 'utility';
    $config['modules']['utility'] = [
        'class' => 'c006\utility\migration\Module',
    ];*/
}

return $config;
