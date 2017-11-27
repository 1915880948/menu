<?php
/**
 * @category AppHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/4/29 12:41
 * @since
 */
namespace qiqi\helper\base;

use yii\base\Object;

/**
 * Class AppHelper
 * @package qiqi\helper
 */
class AppHelper extends Object
{
    public static function getController($autoCreate = true)
    {
        $controller = \Yii::$app->controller;
        if($controller == null && $autoCreate == true){
            $controller = \Yii::$app->createController('site/index')[0];
            \Yii::$app->controller = $controller;
        }
        return $controller;
    }
}
