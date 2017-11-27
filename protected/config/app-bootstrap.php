<?php
/**
 * @category bootstrap.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  6/27/15 21:04
 * @since
 */

$allowPaths = ["_global", "console", defined('APP_GROUP') ? APP_GROUP : APP_NAME];
foreach(glob(Yii::getAlias("@apps/*")) as $path){
    if(is_dir($path)){
        $spath = basename($path);
        if(!in_array($spath, $allowPaths)){
            continue;
        }
        Yii::setAlias($spath, "@apps/{$spath}");
        if(file_exists($path . "/bootstrap.php")){
            include $path . "/bootstrap.php";
        }
    }
}
$psr4 = require VENDOR_PATH . "/composer/autoload_psr4.php";
foreach($psr4 as $k => $value){
    $k = rtrim($k, '\\');
    if(count($value) == 1 && $k !== 'yii'){
        $k = str_replace('\\', '/', $k);
        if(isset(Yii::$aliases[$k])){
            $k .= "__";
        }
        Yii::setAlias($k, $value[0]);
    }
}

