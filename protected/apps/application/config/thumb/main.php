<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/27/15 20:57
 * @since
 */

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
    'components'          => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'bootstrap'           => env('APP') == 'dev' ? ['debug'] : ['log'],
    'modules'             => $modules,
];
