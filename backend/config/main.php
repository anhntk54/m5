<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    // 'defaultRoute' => 'M5',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'posts' => [
            'class' => 'backend\modules\posts\PostModule',
        ],
        'backup' => [
            'class' => 'spanjeta\modules\backup\Module',
        ],
        'config' => [
            'class' => 'backend\modules\config\ConfigModule',
        ],
        'M5' => [
            'class' => 'backend\modules\M5\M5Module',
        ],
        'Users' => [
            'class' => 'backend\modules\Users\UsersModule',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => array('site/login'),
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'cron/<id:\d+>/<code>' => 'M5/cron/check',
            ],
        ],
    ],
    'params' => $params,
];
