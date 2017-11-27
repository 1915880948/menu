<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/24/15 10:22
 * @since
 */

return [
    'vendorPath'  => VENDOR_PATH,
    'runtimePath' => PROJECT_ROOT . "/runtime",
    'timeZone'    => 'Asia/Chongqing',
    'language'    => 'zh-CN',

    'components' => [
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        /** @see yii\web\urlManager */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            //'suffix'          => '.html',
            'rules'           => [
                '<controller:\w+>'              => '<controller>/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'redis'      => [
            'class' => 'yii\redis\Connection',
        ],
        'session'    => [
            'class' => 'yii\web\Session',
        ],
        'db'         => [
            'class'       => 'yii\db\Connection',
            'dsn'         => 'mysql:host=localhost;dbname=neatcn_com', // MySQL, MariaDB
            'username'    => 'root', //数据库用户名
            'password'    => '123456', //数据库密码
            'charset'     => 'utf8mb4',
            'tablePrefix' => 'sablog_',
        ],
        //        'errorHandler'      => [
        //            'errorAction' => 'site/error',
        //        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'bootstrap'  => ['log'],
];
