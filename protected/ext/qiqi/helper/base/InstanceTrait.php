<?php
/**
 * @category InstanceTrait
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/29 12:33
 * @since
 */
namespace qiqi\helper\base;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

trait InstanceTrait
{
    protected static $instance;

    /**
     * @param array $params
     * @return object|InstanceTrait|static|self
     * @throws \yii\base\InvalidConfigException
     */
    public static function getInstance($params = [])
    {
        return self::getSingleton($params);
    }

    /**
     * @param array $params
     * @return object|InstanceTrait|static|self
     * @throws \yii\base\InvalidConfigException
     */
    public static function getSingleton($params = [])
    {
        $uniqueId = md5(Json::encode($params));
        if(!isset(self::$instance[$uniqueId])){
            self::$instance[$uniqueId] = \Yii::createObject(ArrayHelper::merge(['class' => get_called_class()], $params));
            if(method_exists(self::$instance[$uniqueId], 'init')){
                self::$instance[$uniqueId]->init();
            }
        }

        return self::$instance[$uniqueId];
    }

    public static function __callStatic($name, $arguments)
    {
    }
}
