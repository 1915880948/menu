<?php
/**
 * @category AjaxForm
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/10 16:43
 * @since
 */
namespace common\core\base;

use yii\base\Model;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Class AjaxForm
 * @package common\core\base
 */
class AjaxForm
{
    public static function validate($model, $attributes = null)
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $result = [];
        if($attributes instanceof Model){
            // validating multiple models
            $models = func_get_args();
            $attributes = null;
        } else{
            $models = [$model];
        }
        /* @var $model Model */
        foreach($models as $model){
            if(!$model->hasErrors()){
                $model->validate($attributes);
            }
            foreach($model->getErrors() as $attribute => $errors){
                $result[Html::getInputId($model, $attribute)] = $errors;
            }
        }

        return $result;
    }

    public static function returnTrue()
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        return ['success' => true];
    }
}
