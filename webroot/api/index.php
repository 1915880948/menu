<?php

use Dotenv\Dotenv;

error_reporting(E_ALL);
/**
 * define appname
 */
define('APP_PATH', __DIR__);
define('APP_GROUP', 'application');
define('APP_NAME', basename(__DIR__));

/**
 * config app and project path
 */
define('PROJECT_ROOT', (dirname(dirname(__DIR__))));
define('PROTECTED_PATH', PROJECT_ROOT . "/protected");
define('VENDOR_PATH', PROJECT_ROOT . "/vendor");
/**
 * include datas
 */
require(VENDOR_PATH . '/autoload.php');
$dotdnv = new Dotenv(PROJECT_ROOT);
$dotdnv->load();
define('YII_ENV', getenv('APP_ENV'));
define('YII_DEBUG', strtolower(getenv('APP_DEBUG')) == "true" ? true : false);
if(YII_DEBUG === false){
    error_reporting(7);
}
require(VENDOR_PATH . '/yiisoft/yii2/Yii.php');
/**
 * define config
 */
define('PROJECT_CONFIG_PATH', PROTECTED_PATH . "/config");
define('PROJECT_GLOBAL_CONFIG_PATH', PROJECT_CONFIG_PATH . "/_global");
define('APP_CONFIG_PATH', PROTECTED_PATH . "/apps/" . APP_GROUP . "/config");

/**
 * 加载全局bootstrap
 */
require(PROJECT_GLOBAL_CONFIG_PATH . '/bootstrap.php');
require(PROJECT_CONFIG_PATH . "/app-bootstrap.php");
/**
 * 加载扩展的bootstrap
 */
require(PROTECTED_PATH . '/ext/bootstrap.php');

/**
 * merge configs
 */
$config = yii\helpers\ArrayHelper::merge( //all configs
    require(PROJECT_GLOBAL_CONFIG_PATH . '/main.php'), //global main
    require(APP_CONFIG_PATH . '/main.php'), require(APP_CONFIG_PATH . '/' . APP_NAME . '/main.php'));

/**
 * application run
 */
$application = new yii\web\Application($config);

if(file_exists(Yii::getAlias("@application/routers.php"))){
    $routers = include Yii::getAlias("@application/routers.php");
    if(is_array($routers)){
        Yii::$app->urlManager->addRules($routers);
    }
}

$application->run();

if(env("PROFILE_LOG") == true){
    qiqi\helper\log\FileLogHelper::xlog([
        'router'        => Yii::$app->controller->getRoute(),
        "process_time"  => Yii::getLogger()
                              ->getElapsedTime(),
        "include_files" => count(get_included_files())
    ], 'processed');
}
