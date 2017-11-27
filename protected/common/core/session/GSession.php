<?php
/**
 * @category AdminSession
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/22 19:27
 * @since
 */
namespace common\core\session;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class GSession
 * @package common\core\session
 */
trait GSession
{
    public static $sessionKey = '__CommonSession';
    /**
     * @var string 专门用来做提示用
     */
    public static $infoKey = '__tipInfo';

    public static function get($key, $defaultValue = null)
    {
        $datas = \Yii::$app->getSession()->get(self::$sessionKey);

        return ArrayHelper::getValue($datas, $key, $defaultValue);
    }

    public static function set($key, $value = null)
    {
        $datas = \Yii::$app->getSession()->get(self::$sessionKey);
        if($value === null){
            unset($datas[$key]);
        } else{
            $datas[$key] = $value;
        }

        \Yii::$app->getSession()->set(self::$sessionKey, $datas);
    }

    /**
     * @return mixed
     */
    public static function getInfo()
    {
        return self::get(self::$infoKey);
    }

    /**
     * @param $value
     */
    public static function setInfo($value)
    {
        self::set(self::$infoKey, $value);
    }

    public static function setDbError(Model $model)
    {
        if($model->hasErrors()){
            \Yii::$app->getSession()->setFlash('error', join(",", $model->getFirstErrors()));
        }
    }

    public static function getDbError()
    {
        return \Yii::$app->getSession()->getFlash('error');
    }

    /**
     * @param $name
     * @param null $defaultValue
     */
    public static function sget($name, $defaultValue = null)
    {
        return \Yii::$app->getSession()->get($name, $defaultValue);
    }

    public static function sset($name, $value)
    {
        return \Yii::$app->getSession()->set($name, $value);
    }
}
