<?php
/**
 * @category bootstrap.php
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/8 00:18
 * @since
 */
Yii::setAlias('webstatic', getenv('WEB_STATIC'));
Yii::setAlias('webuploads', getenv('WEB_UPLOADS'));
Yii::setAlias('uploads', getenv('PATH_UPLOADS'));
Yii::setAlias('webthumb', getenv('WEB_THUMB'));
Yii::setAlias('domain', getenv('APP_URL'));

/**
 * define devmode
 * 如果域名中有.dev.或者localhost或者URI中有debug=1
 * 开启debug mode
 */
define('IS_DEV_MODE', (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], ".dev.") !== false) ||
                      (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'debug=1') !== false) ||
                      (isset($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], "localhost") !== false));
/**
 * 判断是否本地模式
 */
define('IS_LOCAL_MODE', env('IS_LOCAL_DEV'));

if(file_exists(__DIR__ . "/functions.php")){
    include __DIR__ . "/functions.php";
}
