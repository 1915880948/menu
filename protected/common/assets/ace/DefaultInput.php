<?php
/**
 * @category DefaultInput
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/7/13 09:04
 * @since
 */
namespace common\assets\ace;

use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultInput
 *
 * @package common\assets\ace
 */
class DefaultInput extends Object
{
    static protected $options
        = [
            'placeholder' => '',
            'class'       => 'col-xs-10 col-sm-5',
        ];

    static public function setOptions($model, $attribute, $options)
    {
        $options = ArrayHelper::merge(self::$options, $options);
        $options['value'] = (isset($model->$attribute) && $model->$attribute !== null)
            ? $model->$attribute : 0;
    }

    static public function setDefaultValue($value, $default = '')
    {
        if ($value === null) {
            return $default;
        }

        return $value;
    }
}
