<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/27/15 20:57
 * @since
 */

$params = require(__DIR__ . '/params.php');
$name = defined('APP_GROUP') ? APP_GROUP : APP_NAME;
if($name === "console"){
    $name = basename(__DIR__);
}
return [
    'runtimePath' => PROJECT_ROOT . "/runtime/{$name}",
    'components'  => [
        'request'    => [
            'cookieValidationKey' => env('COOKIE_VALIDE_KEY'),
            'enableCsrfCookie'    => true,
            'csrfCookie'          => [
                'domain' => isset($params['cookie']['domain']) ? $params['cookie']['domain'] : null,
                'path'   => isset($params['cookie']['path']) ? $params['cookie']['path'] : null,
            ],
        ],
        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName'  => false,
        //     //'suffix'          => '.html',
        //     'rules'           => [
        //         '<controller:\w+>/'             => '<controller>/index',
        //         '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        //     ],
        // ],
        /** @see yii\web\session */
        'session'    => [
            'cookieParams' => [
                'httponly' => true,
                'domain' => isset($params['cookie']['domain']) ? $params['cookie']['domain'] : null,
            ],
        ],
        'db'         => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => env('DB_DSN'), // MySQL, MariaDB
            'username'            => env('DB_USERNAME'), //数据库用户名
            'password'            => env('DB_PASSWORD'), //数据库密码
            'charset'             => 'utf8mb4',
            'tablePrefix'         => env('DB_PREFIX'),
            'enableSchemaCache'   => true,
            'schemaCacheDuration' => 3600,
            'schemaCache'         => 'cache',
        ],
        'cache'      => [
            /** @see yii\caching\FileCache */
            'class'          => 'yii\caching\FileCache',
            'directoryLevel' => 2,
        ],
    ],
    'bootstrap'   => ['log'],
    'modules'     => [
        'debug' => [
            'class' => 'yii\debug\Module'
        ]
    ],
    'params'      => $params,
];
