<?php
/**
 * @category AceLabel
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/1/24 17:01
 * @since
 */
namespace common\assets\ace;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class AceLabel
 * @package common\assets\ace
 */
class AceLabel extends Html
{
    static public function showLabel($text, $classes = '')
    {
        $_class = ['label'];
        if(!$classes){
            $_class[] = 'label-default';
        } else{
            if(strpos($classes, 'label-') !== false){
                $_class[] = $classes;
            } else{
                $_class[] = "label-{$classes}";
            }
        }
        return Html::tag("span", $text, ['class' => join(" ", $_class)]);
    }

    /**
     * @param $value
     * @param array $valueItems
     * @return string
     */
    static public function show($value, $valueItems = [])
    {
        switch($value){
            case -1:
                $label = ['label' => ArrayHelper::getValue($valueItems, $value, '已删除'), 'class' => 'label-danger'];
                break;
            case 1:
                $label = ['label' => ArrayHelper::getValue($valueItems, $value, '已上线'), 'class' => 'label-success'];
                break;
            case 0:
            default:
                $label = ['label' => ArrayHelper::getValue($valueItems, $value, '待审核'), 'class' => 'label-warning'];
                break;
        }

        return Html::label($label['label'], [], [
            'class' => "label " . $label['class'],
        ]);
    }
}
