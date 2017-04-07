<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'homeUrl' => '/',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'M5',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'Member' => [
            'class' => 'frontend\modules\Member\MemberModule',
        ],
        'M5' => [
            'class' => 'frontend\modules\M5\M5Module',
        ],
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'm5.hotro@gmail.com',
                'password' => 'M5!@#%2016',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\Member',
            'enableAutoLogin' => true,
            'loginUrl' => array('/Member/default/login'),
            'authTimeout' => 60 * 60 * 12,
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
        'request' => [
            'baseUrl' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                 '<controller:\w+>/<id:\d+>' => '<controller>/view',
             '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
             '<controller:\w+>/<action:\w+>'  => '<controller>/<action>',
                'cron/<id:\d+>/<code>' => 'M5/cron/check',
                'dang-ky-giao-dich'=>'M5/default/give',
                'danh-sach-pd'=>'M5/default/list',
                'danh-sach-gd'=>'M5/default/listtake',
                'danh-sach-giao-dich/<id:\d+>'=>'M5/m5map/index',
                'chi-tiet-giao-dich/<id:\d+>'=>'M5/m5map/view',
                'chi-tiet-giao-dich-pin/<id:\d+>'=>'M5/pin/view',
                'chuyen-pin'=>'M5/pin/create',
                'danh-sach-mua-pin'=>'M5/pin/list',
                'danh-sach-pin'=>'M5/pin/',
                'danh-sach-hoa-hong'=>'M5/roses/',
                'nhan-hoa-hong'=>'M5/roses/create',
                'kich-hoat/<id:\d+>/<key>' => 'Member/default/activate',
                'danh-muc/<slug>' => 'M5/default/index',
                'bai-viet/<slug>' => 'M5/default/post',
                'thay-doi-tai-khoan' => 'Member/default/changeinfo',
                'thay-doi-mat-khau' => 'Member/default/changepassword',
                'dang-ky-thanh-vien' => 'Member/default/create',
                'dang-ky/<key:\w+>' => 'Member/default/signup',
                'thong-tin-ca-nhan' => 'Member/default/index',
                'thong-tin-bat-buoc' => 'Member/default/info',
                'mang-luoi-nguoi-dung' => 'Member/default/tree',
                'login' => 'Member/default/login',
                'logout' => 'Member/default/logout',
                'yeu-cau-mat-khau' => 'Member/default/requestpasswordreset',
                'cai-lai-mat-khau/<token:\w+>' => 'Member/default/resetpassword',
                'tat-ca-thong-bao'=>'M5/logs/index',
                'xem-them-thong-bao'=>'M5/logs/more',
                'suffix'          => '/',
            ],
        ],
    ],
    'params' => $params,
];
