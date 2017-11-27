<?php
/**
 * @category Configure
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/11 23:25
 * @since
 */
namespace common\core\base;

use yii\base\Object;

/**
 * Class Configure
 * @package app\common\base
 */
class Configure extends Object
{
    /**
     * @param $key
     * @param $defaultValue
     */
    public static function get($key, $defaultValue = null)
    {
        $keys = explode(".", $key);
        $_tmp = null;
        foreach($keys as $key){
            if(!$_tmp){
                if(!isset(\Yii::$app->params[$key])){
                    return $defaultValue;
                }
                $_tmp = \Yii::$app->params[$key];
            } else{
                if(!isset($_tmp[$key])){
                    return $defaultValue;
                }
                $_tmp = $_tmp[$key];
            }
        }
        return $_tmp;
    }
}
