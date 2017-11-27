<?php
/**
 * Yii console bootstrap file.
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
use Dotenv\Dotenv;

/**
 * config yii env
 */
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
/**
 * config app and project path
 */
define('PROJECT_ROOT', dirname(dirname(__DIR__)));
define('PROTECTED_PATH', PROJECT_ROOT . '/protected');
/**
 * define appname
 */
define('APP_PATH', PROJECT_ROOT . "/protected/apps/console");
define('APP_NAME', 'console');
/**
 * define config
 */
define('PROJECT_CONFIG_PATH', PROJECT_ROOT . "/protected/config");
define('PROJECT_GLOBAL_CONFIG_PATH', PROJECT_CONFIG_PATH . "/_global");
define('APP_CONFIG_PATH', PROJECT_CONFIG_PATH . "/" . APP_NAME);
/**
 * define vendor
 */
define('VENDOR_PATH', PROJECT_ROOT . "/vendor");
/**
 * include datas
 */
require(VENDOR_PATH . '/autoload.php');
// if($_SERVER['argv']){
//     foreach($_SERVER['argv'] as $k => $param){
//         $projectPrefix = '--project=';
//         if(substr($param, 0, strlen($projectPrefix)) == $projectPrefix){
//             $project = str_replace($projectPrefix, "", $param);
//             $dotdnv = new Dotenv(PROJECT_ROOT, ".env.{$project}");
//             $dotdnv->load();
//         }
//     }
// }
$dotdnv = new Dotenv(PROJECT_ROOT);
$dotdnv->load();
define('YII_ENV', getenv('APP_ENV') ?: 'dev');
define('YII_DEBUG', strtolower(getenv('APP_DEBUG')) == "true" ? true : false);

define('YII_PROJECT', isset($project) ? $project : "");
define('YII_GROUP', isset($project) ? $project : "");

require(VENDOR_PATH . '/yiisoft/yii2/Yii.php');
require(PROJECT_GLOBAL_CONFIG_PATH . '/bootstrap.php');
require(PROJECT_CONFIG_PATH . '/app-bootstrap.php');
/**
 * 加载扩展的bootstrap
 */
require(PROJECT_ROOT . '/protected/ext/bootstrap.php');
