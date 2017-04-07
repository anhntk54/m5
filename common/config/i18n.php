<?php
return [
  'sourcePath' => __DIR__. DIRECTORY_SEPARATOR .'..',
// Root directory containing message translations.
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR . 'messages',
    'languages' => ['vi-VN','en-US'], //Add languages to the array for the language files to be generated.
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/vendor',
    ],
    'format' => 'php',
    'overwrite' => true,
];
