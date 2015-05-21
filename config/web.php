<?php

$params = require(__DIR__ . '/params.php');
$theme = "basic";

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'components' => [
        'urlManager' => [
            'class'=>'app\components\SUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                'admin/<module:\w+>'=>'<module>/admin/default',
                'admin/<module:\w+>/<controller:\w+>'=>'<module>/admin/<controller>',
                'admin/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/admin/<controller>/<action>',
                'admin/'  => 'admin/default/index',
                'login/'  => 'site/login',

            ],
        ],
        'request' => [
            'cookieValidationKey' => 'morozoff',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'user',
                'moderator',
                'admin',
                'superadmin'
            ],
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
            'useFileTransport' => false,
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
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/'.$theme,'@app/modules' => '@app/themes/'.$theme.'/modules','@app/components/widgets' => '@app/themes/'.$theme.'/widgets'],
                'baseUrl' => '@web/themes/'.$theme,
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        /*'news' => [
            'class' => 'app\modules\news\NewsModule',
        ],*/
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
