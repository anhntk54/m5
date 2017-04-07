<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'vi-VN',
//    'sourceLanguage'=>'en-US',
    'components' => [
      'i18n' => [
          'translations' => [
              'app*' => [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'basePath' => '@common/messages',
//                  'sourceLanguage'=>'en-US',
                  'fileMap' => [
                      'app' => 'app.php',
                  ],
              ],
          ],
      ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    
    ],
];
