<?php
/**
 * @category FileLogHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 10/12/15 16:22
 * @since
 */

namespace qiqi\helper\log;

use yii\base\Component;
use yii\helpers\Console;
use yii\helpers\Json;

/**
 * Class FileLogHelper
 * @package neatstudio\logger
 */
class FileLogHelper extends Component
{
    public static $debug = true;
    public static $logSuffix = ".log";

    public static function setDebug($debug = true)
    {
        self::$debug = (bool) $debug;
    }

    public static function xlog($message, $trace = null, $type = '')
    {
        if($message === 'full'){
            $message = [$_GET, $_POST, $_REQUEST, $_FILES, $_SERVER, file_get_contents("php://input")];
        }
        $message = sprintf("[%s]%s", date('Y-m-d H:i:s'), is_string($message) ? $message : Json::encode($message));
        self::log($message, $trace, $type);
    }

    /**
     * 普通的LOG
     * @param $message
     * @param $trace
     * @param $type
     */
    public static function log($message, $trace = null, $type = '')
    {
        if(!self::isDebugMode()){
            return;
        }
        $ret = is_string($message) ? $message : Json::encode($message);
        $ret .= "\n";
        try{
            error_log($ret, 3, self::getLogFile($trace, $type));
        } catch(\Exception $e){
            @file_put_contents(self::getLogFile($trace, $type), $ret, FILE_APPEND);
        }
    }

    /**
     * 重要的LOG，即使debug关了。这个也能记录。存储路径不一样
     * @param $message
     * @param $category
     * @param $type
     */
    public static function syslog($message, $category = 'default', $type = '')
    {
        $ret = (is_string($message) ? $message : Json::encode($message)) . "\n";
        $ret = sprintf("[%s] %s \n", date("H:i:s"), $ret);
        try{
            error_log($ret, 3, self::getSysLogFile($category, $type));
        } catch(\Exception $e){
            @file_put_contents(self::getSysLogFile($category, $type), $ret, FILE_APPEND);
        }
    }

    /**
     * @param      $message
     * @param bool $ret
     * @return string
     */
    public static function show($message, $ret = false)
    {

        $data = sprintf("[%s]%s\n", date("Y-m-d H:i:s"), is_string($message) ? $message : Json::encode($message));
        if($ret === true){
            return $data;
        }

        return Console::output($data);
    }

    public static function shell($message, $status = '')
    {
        $status = strtoupper($status);
        switch($status){
            case "SUCCESS":
                $out = "[42m"; //Green background
                break;
            case "FAILURE":
                $out = "[41m"; //Red background
                break;
            case "WARNING":
                $out = "[43m"; //Yellow background
                break;
            case "NOTE":
                $out = "[44m"; //Blue background
                break;
            default:
                $out = "[47m"; //Blue background
                break;
        }
        echo sprintf("[%s]%s%s%s%s[0m\n", date("Y-m-d H:i:s"), chr(27), $out, (is_string($message) ? $message : Json::encode($message)), chr(27));
        //return chr(27) . "$out" . "$data" . chr(27) . "[0m";
    }

    protected static function isDebugMode()
    {
        return ((isset(\Yii::$app->params['app.debug']) && \Yii::$app->params['app.debug']) || self::$debug === true);
    }

    protected static function getLogFile($trace = null, $type = '')
    {
        $ymd = date("Ymd");
        if($type){
            $ymd = $type;
        }
        if($trace){
            $trace = strval($trace);
            $file = self::getLogPath() . "/user/{$trace}/{$ymd}" . self::$logSuffix . "";
        } else{
            $file = self::getLogPath() . "/trace/{$ymd}.log";
        }
        if(!is_dir(dirname($file))){
            mkdir(dirname($file), 0777, true);
        }
        if(!file_exists($file)){
            @touch($file);
        }

        return $file;
    }

    /**
     * 定义log存放的路径
     * @return string
     */
    protected static function getLogPath()
    {
        $logPath = \Yii::getAlias("@runtime/applog");
        if(!is_dir($logPath)){
            mkdir($logPath, 0777, true);
        }
        return realpath($logPath);
    }

    protected static function getSysLogFile($category = 'default', $type = '')
    {
        $ymd = date("Ymd");
        if($type){
            $ymd = $type;
        }
        $file = self::getLogPath() . "/system/{$category}/{$ymd}.log";
        if(!is_dir(dirname($file))){
            mkdir(dirname($file), 0777, true);
        }
        if(!file_exists($file)){
            @touch($file);
        }

        return $file;
    }
}
