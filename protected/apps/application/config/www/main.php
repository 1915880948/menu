<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/27/15 20:57
 * @since
 */

use common\core\template\blade\BladeView;
use common\core\template\blade\ViewRenderer;

$appId = basename(__DIR__);
$appName = defined('APP_GROUP') ? APP_GROUP : APP_NAME;
$modules = [];
$viewPaths = [];
foreach(glob(Yii::getAlias("@{$appName}/web/{$appId}/modules/*")) as $item){
    if(is_dir($item) && file_exists($item . "/config.php")){
        $config = include $item . "/config.php";
        if(isset($config['class'])){
            if(!isset($config['id'])){
                $config['id'] = md5($config['class']);
            }
            $modules[$config['id']] = $config;
            $viewPaths[] = $item."/views";
        }
    }
}
return [
    'id'                  => $appId,
    'name'                => $appId,
    'basePath'            => "@{$appName}/web/{$appId}",
    'viewPath'            => "@{$appName}/web/{$appId}/views",
    'controllerNamespace' => "{$appName}\\web\\{$appId}\\controllers",
    'language'            => 'en',
    'components'          => [
        'user'         => [
            'identityClass'   => "{$appName}\\web\\{$appId}\\WwwUser",
            'idParam'         => '__www',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_www_identity',
                'httpOnly' => true,
                'domain'   => isset($params['cookie']['domain']) ? $params['cookie']['domain'] : null,
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            // 'hashCallback'    => function ($path) {
            //     return hash('md4', $path);
            // }
        ],
        'view'         => [
            'class'            => BladeView::className(),
            'defaultExtension' => 'blade.php',
            'renderers'        => [
                'blade' => [
                    // 'class'     => '\cyneek\yii2\blade\ViewRenderer',
                    'class'     => ViewRenderer::className(),
                    'cachePath' => '@runtime/cache',
                ],
            ],
        ],
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@application/messages',
                    // // 'sourceLanguage' => 'zh-CN',
                    'fileMap'  => [
                        'www'       => 'www.php',
                        'www/error' => 'www.error.php',
                    ],
                ],
            ],
        ],
    ],
    'bootstrap'           => env('APP') == 'dev' ? ['debug', 'log'] : ['log'],
    'modules'             => $modules,
];
