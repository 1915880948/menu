<?php
/**
 * @category main.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/27/15 20:57
 * @since
 */

use yii\gii\Module;

$params = array_merge( //ALL PARAMS
    require(PROJECT_GLOBAL_CONFIG_PATH . '/params.php'),//global params
    require(__DIR__ . '/params.php')//app params
);
$appId = basename(__DIR__);
return [
    'id'                  => $appId,
    'name'                => $appId,
    'basePath'            => APP_PATH,
    'controllerNamespace' => "console\\controllers",
    'components'          => [
    ],
    'params'              => $params,
    'bootstrap'           => [
        'tools'
    ],
    'modules'             => [
        'tools' => console\modules\tools\Module::className()
    ],
    'controllerMap' => [
    ],
];
